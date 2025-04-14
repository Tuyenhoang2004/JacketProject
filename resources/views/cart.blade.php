@extends('layouts.app')

@section('content')
@include('layouts.menu')
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: center;
        vertical-align: middle;
    }
    .btn-thanh-toan {
        background-color: #28a745; /* xanh lá */
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .btn-thanh-toan:hover {
        background-color: #218838;
    }
</style>

</style>
<div class="container">
    <h2>Giỏ hàng của bạn</h2>

    @if(session('success'))
        <p style="color: green">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p style="color: red">{{ session('error') }}</p>
    @endif

    @if(count($cart) > 0)
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="background-color: #f2f2f2;">
                    <th style="padding: 10px; border: 1px solid #ccc;">Sản phẩm</th>
                    <th style="padding: 10px; border: 1px solid #ccc;">Size</th>
                    <th style="padding: 10px; border: 1px solid #ccc;">Số lượng</th>
                    <th style="padding: 10px; border: 1px solid #ccc;">Giá gốc</th>
                    <th style="padding: 10px; border: 1px solid #ccc;">Giảm giá</th>
                    <th style="padding: 10px; border: 1px solid #ccc;">Giá sau giảm</th>
                    <th style="padding: 10px; border: 1px solid #ccc;">Tổng</th>
                    <th style="padding: 10px; border: 1px solid #ccc;">Xoá</th>
                </tr>
            </thead>
            <tbody>
            @foreach($cart as $item)
    @if(isset($item['product_id']) && isset($item['price']))
        <tr>
            <td style="padding: 10px; border: 1px solid #ccc;">{{ $item['product_name'] ?? 'N/A' }}</td>
            <td style="padding: 10px; border: 1px solid #ccc;">{{ $item['size'] ?? 'N/A' }}</td>
            <td style="padding: 10px; border: 1px solid #ccc;">{{ $item['quantity'] ?? 1 }}</td>
            <td stype="padding: 10px; border: 1px solid #ccc;">{{ number_format($item['price'], 0, ",", ".") }} VNĐ</td>
            <td style="padding: 10px; border: 1px solid #ccc;">{{ $item['discountValue'] ?? 1 }}%</td>
            <td style="padding: 10px; border: 1px solid #ccc;">
            {{ number_format($item['price_after_discount'], 0, ",", ".") }} VNĐ
            </td>
            <td style="padding: 10px; border: 1px solid #ccc;">
                {{ number_format(($item['price_after_discount'] ?? $item['price']) * $item['quantity'], 0, ',', '.') }} VNĐ
            </td>
            <td style="padding: 10px; border: 1px solid #ccc;">
                <form method="POST" action="{{ route('cart.remove') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                    <input type="hidden" name="size" value="{{ $item['size'] }}">
                    <button type="submit" style="background-color: red; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer;">
                        Xoá
                    </button>
                </form>
            </td>
        </tr>
    @endif
@endforeach

            </tbody>
        </table>
        <div style="text-align: right; margin-top: 20px;">
            <a href="{{ route('checkout') }}" class="btn-thanh-toan">Thanh toán</a>
        </div>

    @else
        <p>Giỏ hàng trống.</p>
    @endif

</div>
@endsection
