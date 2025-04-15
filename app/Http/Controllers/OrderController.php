<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\Auth;


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
    public function details(Request $request)
{
    $allowedStatuses = ['Chờ xử lý', 'Hoàn thành', 'Đã hủy'];

    $query = Order::query();

    // Nếu có lọc ngày
    if ($request->filled('from_date') && $request->filled('to_date')) {
        $query->whereBetween('OrderDate', [
            $request->from_date . ' 00:00:00',
            $request->to_date . ' 23:59:59'
        ]);
    }

    $orders = $query->get();

    return view('admin.orders.details', compact('orders', 'allowedStatuses'));
}


    public function updateStatus($orderId, $status)
    {
        // Tìm đơn hàng cần cập nhật
        $order = Order::findOrFail($orderId);

        // Cập nhật trạng thái đơn hàng
        $order->StatusOrders = $status;
        $order->save();

        // Trở lại trang lịch sử mua hàng với thông báo thành công
        return redirect()->route('checkout.history')->with('success', 'Trạng thái đơn hàng đã được cập nhật');
    }

    public function show($id)
{
    $order = Order::with('orderDetails.product')->find($id);

    if (!$order) {
        abort(404, 'Đơn hàng không tồn tại');
    }

    return view('admin.orders.order-detail', compact('order'));
}

public function orderstatistics(Request $request)
{
    $query = DB::table('orders');

    // Nếu có khoảng ngày được chọn
    if ($request->filled('from_date') && $request->filled('to_date')) {
        $query->whereBetween('OrderDate', [
            $request->from_date . ' 00:00:00',
            $request->to_date . ' 23:59:59',
        ]);
    }

    $totalOrders = $query->count();

    // Clone lại query cho từng loại, tránh ảnh hưởng
    $completedOrders = (clone $query)->where('StatusOrders', 'Hoàn thành')->count();
    $cancelledOrders = (clone $query)->where('StatusOrders', 'Đã huỷ')->count();
    $totalRevenue = (clone $query)->where('StatusOrders', 'Hoàn thành')->sum('TotalAmount');

    return view('admin.orders.order-statistics', compact(
        'totalRevenue',
        'totalOrders',
        'completedOrders',
        'cancelledOrders'
    ));
}

    public function history()
{
    if (!Auth::check()) {
        session()->put('warning', 'Vui lòng đăng nhập để xem lịch sử mua hàng');
        return redirect()->route('login');
    }

    $user = Auth::user();
    $orders = Order::with(['orderDetails.product'])
                   ->where('UserID', $user->UserID)
                   ->get();

    return view('history', compact('orders'));
}



}

    