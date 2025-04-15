@extends('layouts.app')

@section('content')
@include('layouts.menu')

<style>
    .cart-container {
        max-width: 1000px;
        margin: 40px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    h2.cart-title {
        text-align: center;
        font-size: 32px;
        font-weight: bold;
        color: #333;
        margin-bottom: 30px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: center;
        vertical-align: middle;
    }

    th {
        background-color: #f8f9fa;
        font-weight: bold;
        color: #333;
    }

    .btn-thanh-toan {
        background-color: #28a745;
        color: white;
        padding: 10px 25px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .btn-thanh-toan:hover {
        background-color: #218838;
    }

    .btn-delete {
        background-color: red;
        color: white;
        border: none;
        padding: 5px 12px;
        border-radius: 5px;
        cursor: pointer;
    }

    .total-row {
        font-weight: bold;
        background-color: #f1f1f1;
    }
</style>

<div class="cart-container">
    <h2 class="cart-title">Giỏ hàng của bạn</h2>

    @if(session('success'))
        <p style="color: green; text-align: center;">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p style="color: red; text-align: center;">{{ session('error') }}</p>
    @endif

    @if(count($cart) > 0)
        <table>
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Size</th>
                    <th>Số lượng</th>
                    <th>Giá gốc</th>
                    <th>Giảm giá</th>
                    <th>Giá sau giảm</th>
                    <th>Tổng</th>
                    <th>Xoá</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $item)
                    @if(isset($item['product_id']) && isset($item['price']))
                        <tr>
                            <td>{{ $item['product_name'] ?? 'N/A' }}</td>
                            <td>{{ $item['size'] ?? 'N/A' }}</td>
                            <td>{{ $item['quantity'] ?? 1 }}</td>
                            <td>{{ number_format($item['price'], 0, ",", ".") }} VNĐ</td>
                            <td>{{ $item['discountValue'] ?? 0 }}%</td>
                            <td>{{ number_format($item['price_after_discount'], 0, ",", ".") }} VNĐ</td>
                            <td>{{ number_format(($item['price_after_discount'] ?? $item['price']) * $item['quantity'], 0, ',', '.') }} VNĐ</td>
                            <td>
                                <form method="POST" action="{{ route('cart.remove') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                    <input type="hidden" name="size" value="{{ $item['size'] }}">
                                    <button type="submit" class="btn-delete">Xoá</button>
                                </form>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <div style="text-align: right; margin-top: 25px;">
            <a href="{{ route('checkout') }}" class="btn-thanh-toan">Đặt hàng</a>
        </div>
    @else
        <p style="text-align: center;">Giỏ hàng trống.</p>
    @endif
</div>
@endsection
