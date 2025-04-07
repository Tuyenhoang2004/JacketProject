@extends('layouts.app')

@section('content')
@include('layouts.menu')
<div class="container">
    <h2>Giỏ hàng</h2>
    @if(session('cart') && count(session('cart')) > 0)
        <table>
            <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Size</th>
                <th>Số lượng</th>
                <th>Giá gốc</th>
                <th>Giảm</th>
                <th>Giá sau giảm</th>
                <th>Tổng</th>
            </tr>

            </thead>
            <tbody>
            @foreach(session('cart') as $item)
                @php
                    $originalPrice = $item['price'];
                    $discountValue = $item['discount_value'] ?? 0;

                    // Nếu DiscountValue là phần trăm:
                    $priceAfterDiscount = $originalPrice;
                    if ($discountValue > 0 && $discountValue < 100) {
                        $priceAfterDiscount = $originalPrice * (1 - $discountValue / 100);
                    }

                    $total = $priceAfterDiscount * $item['quantity'];
                @endphp
                <tr>
                    <td>{{ $item['product_name'] }}</td>
                    <td>{{ $item['size'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ number_format($originalPrice, 0, ',', '.') }} VNĐ</td>
                    <td>-{{ $discountValue }}%</td>
                    <td>{{ number_format($priceAfterDiscount, 0, ',', '.') }} VNĐ</td>
                    <td>{{ number_format($total, 0, ',', '.') }} VNĐ</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    @else
        <p>Giỏ hàng đang trống.</p>
    @endif
</div>
@endsection
