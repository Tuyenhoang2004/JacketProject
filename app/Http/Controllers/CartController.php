<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return view('cart', compact('cart')); // 👉 đúng rồi, view là cart.blade.php
    }

    public function add(Request $request)
{
    // Lấy dữ liệu từ form và ép kiểu nếu cần
    $product_id = $request->input('product_id');
    $product_name = $request->input('product_name');
    $price = (int) $request->input('price');
    $size = $request->input('size');
    $quantity = (int) $request->input('quantity');
    $discountValue = (int) $request->input('discountValue');

    // Kiểm tra dữ liệu cần thiết
    if (!$product_id || !$product_name || !$price || !$size || !$quantity) {
        return redirect()->back()->with('error', 'Thiếu thông tin sản phẩm.');
    }

    // Tính giá sau giảm
    $discount_amount = ($price * $discountValue) / 100;
    $price_after_discount = $price - $discount_amount;

    // Lấy giỏ hàng hiện tại từ session
    $cart = session()->get('cart', []);

    // Kiểm tra nếu sản phẩm đã tồn tại (cùng ID và size) thì cộng thêm số lượng
    $found = false;
    foreach ($cart as &$item) {
        if (
            isset($item['product_id'], $item['size']) &&
            $item['product_id'] == $product_id &&
            $item['size'] == $size
        ) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }
    
    
    // Nếu chưa có trong giỏ thì thêm mới
    if (!$found) {
        $cart[] = [
            'product_id' => $product_id,
            'product_name' => $product_name,
            'price' => $price,
            'size' => $size,
            'quantity' => $quantity,
            'discountValue' => $discountValue,
            'price_after_discount' => $price_after_discount,
        ];
    }

    // Lưu lại session
    session()->put('cart', $cart);

    return redirect()->route('cart')->with('success', 'Đã thêm vào giỏ hàng!');
}


    public function remove(Request $request)
    {
        $productId = $request->input('product_id');
        $size = $request->input('size');

        if (!$productId || !$size) {
            return redirect()->back()->with('error', 'Thiếu thông tin sản phẩm để xóa.');
        }

        $cart = session()->get('cart', []);

        foreach ($cart as $index => $item) {
            if ($item['product_id'] == $productId && $item['size'] == $size) {
                unset($cart[$index]);
                break;
            }
        }

        $cart = array_values($cart); // Re-index mảng
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }
}
