<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Hiển thị trang checkout
    public function create()
    {
        // Lấy giỏ hàng từ session
        $cart = session('cart', []);
        
        // Kiểm tra giỏ hàng trống
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Giỏ hàng của bạn hiện tại trống!');
        }

        // Tính tổng tiền của giỏ hàng
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['price_after_discount'];
        }

        return view('checkout', compact('cart', 'total'));
    }

    // Xử lý lưu đơn hàng
    public function store(Request $request)
    {
        // Kiểm tra dữ liệu hợp lệ
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'note' => 'nullable|string',
        ]);

        // Kiểm tra giỏ hàng từ session
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Giỏ hàng trống!');
        }

        // Tính tổng tiền từ giỏ hàng
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['price_after_discount'];
        }

        // Lưu đơn hàng vào database
        $order = Order::create([
            'UserID' => Auth::id() ?? 1,
            'customer_name' => $validated['customer_name'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'note' => $validated['note'] ?? null,
            'OrderDate' => now(),
            'created_at' => now(),
            'updated_at' => now(),
            'TotalAmount' => $total,
            'StatusOrders' => 'Đang xử lý',
        ]);

        // Lưu chi tiết đơn hàng vào bảng OrderDetails
        foreach ($cart as $item) {
            try {
                OrderDetail::create([
                    'OrderID' => $order->OrderID,
                    'ProductID' => $item['product_id'],
                    'Quantity' => $item['quantity'],
                    'UnitPrice' => $item['price_after_discount'],
                ]);
            } catch (\Exception $e) {
                dd($e->getMessage()); // In lỗi nếu có
            }
        }

        // Dọn session và chuyển hướng
        session()->forget('cart');

        return redirect('/')->with('success', 'Đặt hàng thành công!');
    }
}
