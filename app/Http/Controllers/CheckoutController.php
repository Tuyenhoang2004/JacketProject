<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Giỏ hàng của bạn hiện tại trống!');
        }

        $total = collect($cart)->sum(function ($item) {
            return $item['quantity'] * $item['price_after_discount'];
        });

        // Kiểm tra thông tin giao hàng đã được lưu chưa
        $hideForm = session('shipping_info_saved', false);

        return view('checkout', compact('cart', 'total', 'hideForm'));
    }

    public function confirmShipping(Request $request)
    {
        $user = Auth::user(); // Lấy thông tin người dùng hiện tại

        // Validate thông tin người dùng nhập vào
        $request->validate([
            'customer_name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Giỏ hàng trống!');
        }

        // Kiểm tra xem đã có order hay chưa
        if (session()->has('order_id')) {
            return redirect()->back()->with('error', 'Thông tin đã được lưu trước đó.');
        }

        $totalAmount = collect($cart)->sum(function ($item) {
            return $item['price_after_discount'] * $item['quantity'];
        });

        // Tạo order mới
        $order = Order::create([
            'UserID' => auth()->user()->UserID,
            'OrderDate' => now(),
            'TotalAmount' => $totalAmount,
            'StatusOrders' => 'Chờ thanh toán',
            'customer_name' => $request->customer_name,
            'address' => $request->address,
            'phone' => $request->phone,
            'note' => $request->note,
        ]);

        // Lưu vào session order_id và shipping_info_saved
        session([
            'order_id' => $order->OrderID,
            'shipping_info_saved' => true,
        ]);

        // Quay lại trang checkout với thông báo thành công
        return redirect()->route('checkout')->with('success', 'Thông tin giao hàng đã được xác nhận.');
    }

    public function processPayment(Request $request)
{
    $cart = session('cart', []);
    $orderId = session('order_id');

    if (empty($cart) || !$orderId) {
        return redirect()->route('cart')->with('error', 'Không thể thanh toán vì thiếu thông tin đơn hàng.');
    }

    try {
        DB::transaction(function () use ($cart, $orderId) {
            $order = Order::find($orderId);

            if (!$order) {
                throw new \Exception('Không tìm thấy đơn hàng.');
            }

            // Cập nhật trạng thái đơn hàng thành "Đã thanh toán"
            $order->update([
                'StatusOrders' => 'Chờ xử lý',
            ]);

            foreach ($cart as $item) {
                OrderDetails::create([
                    'OrderID' => $order->OrderID,
                    'ProductID' => $item['product_id'],
                    'Quantity' => $item['quantity'],
                    'UnitPrice' => $item['price_after_discount'],
                ]);                              
            }

            // Xoá session
            session()->forget(['cart', 'order_id', 'shipping_info_saved']);
        });

        return redirect()->route('cart')->with('success', 'Đặt hàng thành công!');
    } catch (\Exception $e) {
        return redirect()->route('cart')->with('error', 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại. Lỗi: ' . $e->getMessage());
    }
}


}
