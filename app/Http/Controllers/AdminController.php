<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        // Lấy năm được chọn, nếu không có thì lấy năm hiện tại
        $selectedYear = $request->input('year', date('Y'));
        $years = range(date('Y') - 5, date('Y')); // 5 năm gần nhất
    
        // Doanh thu theo tháng trong năm được chọn
        $orders = DB::table('orders')
            ->select(
                DB::raw('MONTH(OrderDate) as month'),
                DB::raw('SUM(TotalAmount) as total')
            )
            ->whereYear('OrderDate', $selectedYear)
            ->groupBy(DB::raw('MONTH(OrderDate)'))
            ->orderBy(DB::raw('MONTH(OrderDate)'))
            ->get();
    
        // Chuẩn bị dữ liệu biểu đồ
        $doanhThuLabels = [];
        $doanhThuData = [];
        for ($i = 1; $i <= 12; $i++) {
            $doanhThuLabels[] = 'Tháng ' . $i;
            $match = $orders->firstWhere('month', $i);
            $doanhThuData[] = $match ? (int)$match->total : 0;
        }
    
        // Tổng số liệu
        $totalOrders = Order::count();
        $totalRevenue = Order::where('StatusOrders', 'Hoàn thành')->sum('TotalAmount');
        $totalUsers = User::where('role', 'user')->count();
        $totalProducts = Product::count();
    
        // Top 5 sản phẩm bán chạy
        $topProducts = Product::withCount('orderDetails')
            ->orderByDesc('order_details_count')
            ->take(5)
            ->get()
            ->map(function ($product) {
                return (object) [
                    'name' => $product->ProductName,
                    'image_url' => $product->ImageURL ?? 'default.jpg',
                    'sold_quantity' => $product->order_details_count,
                ];
            });
    
        // Top 5 người dùng mua hàng nhiều nhất
        $topUsers = DB::table('orders')
            ->join('orderdetails', 'orders.OrderID', '=', 'orderdetails.OrderID')
            ->join('users', 'orders.UserID', '=', 'users.UserID')
            ->where('orders.StatusOrders', 'Hoàn thành')
            ->select(
                'users.UserName',
                DB::raw('COUNT(orderdetails.OrderID) as TotalOrders')
            )
            ->groupBy('users.UserName')
            ->orderByDesc('TotalOrders')
            ->limit(5)
            ->get();
    
        // Trả về view
        return view('admin.dashboard', [
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'totalUsers' => $totalUsers,
            'totalProducts' => $totalProducts,
            'doanhThuLabels' => $doanhThuLabels,
            'doanhThuData' => $doanhThuData,
            'topProducts' => $topProducts,
            'topUsers' => $topUsers,
            'years' => $years,
            'selectedYear' => $selectedYear,
        ]);
    }
    
  
}
