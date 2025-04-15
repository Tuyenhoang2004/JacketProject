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
    public function details()
    {
        $orders = Order::all();
        $allowedStatuses = ['Chờ xử lý', 'Hoàn thành', 'Đã hủy'];

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
    public function history()
{
    $user = Auth::user();  // Lấy người dùng hiện tại

    // Lấy toàn bộ đơn hàng + chi tiết + sản phẩm
    $orders = Order::with(['orderDetails.product']) // Giả sử đã khai quan hệ orderDetails trong model Order
                ->where('UserID', $user->UserID)
                ->get();

    // Nếu không có đơn hàng
    if ($orders->isEmpty()) {
        return view('history', ['message' => 'Bạn chưa có đơn hàng nào.']);
    }

    // Convert ngày cho dễ đọc (nếu cần)
    foreach ($orders as $order) {
        $order->OrderDate = Carbon::parse($order->OrderDate);
    }

    return view('history', compact('orders'));
}

    





}

    