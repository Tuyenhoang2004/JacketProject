<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
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

        $hideForm = session('shipping_info_saved', false);

        return view('checkout', compact('cart', 'total', 'hideForm'));
    }

    public function confirmShipping(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Giỏ hàng trống!');
        }

        if (session()->has('order_id')) {
            return redirect()->back()->with('error', 'Thông tin đã được lưu trước đó.');
        }

        $totalAmount = collect($cart)->sum(function ($item) {
            return $item['price_after_discount'] * $item['quantity'];
        });

        $order = Order::create([
            'UserID' => auth()->id(),
            'OrderDate' => now(),
            'TotalAmount' => $totalAmount,
            'StatusOrders' => 'Chờ thanh toán',
            'customer_name' => $request->customer_name,
            'address' => $request->address,
            'phone' => $request->phone,
            'note' => $request->note,
        ]);

        session([
            'order_id' => $order->OrderID,
            'shipping_info_saved' => true,
        ]);

        return redirect()->route('checkout.index')->with('success', 'Thông tin giao hàng đã được xác nhận.');
    }

    public function processPayment()
    {
        $orderID = session('order_id');
        $cart = session('cart');

        if (!$orderID || !$cart) {
            return redirect()->route('checkout.index')->with('error', 'Không tìm thấy đơn hàng.');
        }

        foreach ($cart as $item) {
            OrderDetail::create([
                'OrderID' => $orderID,
                'ProductID' => $item['product_id'],
                'Quantity' => $item['quantity'],
                'UnitPrice' => $item['price_after_discount'],
            ]);
        }

        Order::where('OrderID', $orderID)->update(['StatusOrders' => 'Đã thanh toán']);

        // Sau khi thanh toán thành công, xoá hết session liên quan
        session()->forget(['cart', 'order_id', 'shipping_info_saved']);

        return redirect()->route('home')->with('success', 'Đặt hàng và thanh toán thành công!');
    }
}