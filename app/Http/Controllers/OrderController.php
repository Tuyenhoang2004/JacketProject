<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Models\OrderDetail;


class OrderController extends Controller
{
    public function statistics()
    {
        // Tổng doanh thu
        $totalRevenue = Order::sum('TotalAmount');

        // Thống kê theo trạng thái đơn hàng
        $orderStats = Order::select('StatusOrders', DB::raw('COUNT(*) as total'))
            ->groupBy('StatusOrders')
            ->get();

        // Top 5 sản phẩm bán chạy nhất
        $topProducts = DB::table('products')
            ->join('orderdetails', 'products.ProductID', '=', 'orderdetails.ProductID')
            ->join('orders', 'orderdetails.OrderID', '=', 'orders.OrderID')
            ->where('orders.StatusOrders', 'Hoàn thành')
            ->select(
                'products.ProductName',
                DB::raw('SUM(orderdetails.Quantity) as total_sales')
            )
            ->groupBy('products.ProductName')
            ->orderByDesc('total_sales')
            ->limit(5)
            ->get();

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

        // Trả dữ liệu về view
        return view('admin.orders.statistics', compact('totalRevenue','orderStats','topProducts','topUsers'));
    }
    public function details()
    {
        $orders = Order::all();
        $allowedStatuses = ['Chờ xử lý', 'Hoàn thành', 'Đã hủy'];

        return view('admin.orders.details', compact('orders', 'allowedStatuses'));
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id); // Tìm đơn hàng theo ID
    
            $order->StatusOrders = $request->input('StatusOrders'); // Gán trạng thái mới
            $order->save(); // Lưu lại
    
            return response()->json([
                'message' => 'Cập nhật trạng thái thành công!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Có lỗi xảy ra khi cập nhật!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
{
    $order = Order::with('orderDetails.product')->find($id);

    if (!$order) {
        abort(404, 'Đơn hàng không tồn tại');
    }

    return view('admin.orders.order-detail', compact('order'));
}

    public function orderstatistics()
    {
        $totalRevenue = DB::table('orders')
            ->where('StatusOrders', 'Hoàn thành')
            ->sum('TotalAmount');

        $totalOrders = DB::table('orders')->count();
        $completedOrders = DB::table('orders')->where('StatusOrders', 'Hoàn thành')->count();
        $cancelledOrders = DB::table('orders')->where('StatusOrders', 'Đã huỷ')->count();

        return view('admin.orders.order-statistics', compact(
            'totalRevenue',
            'totalOrders',
            'completedOrders',
            'cancelledOrders'
        ));
    }




}

    