@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<div class="container mt-5">
@if($order)
    <h2>Chi tiết đơn hàng #{{ $order->OrderID }}</h2>
    <p><strong>Khách hàng:</strong> {{ $order->UserID }}</p>
    <p><strong>Ngày đặt hàng:</strong> {{ \Carbon\Carbon::parse($order->OrderDate)->format('d/m/Y') }}</p>
    <p><strong>Thành tiền:</strong> 
        {{ number_format($order->orderDetails->sum(function($item) {
            return $item->UnitPrice * $item->Quantity;
        }), 0, ',', '.') }} VND
    </p>

    <p><strong>Trạng thái:</strong> {{ $order->StatusOrders }}</p>
    @endif
    <hr>

    <h4>Chi tiết sản phẩm:</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
        @foreach($order->orderDetails as $detail)
            <tr>
                <td>{{ $detail->product->ProductName ?? 'N/A' }}</td>
                <td>{{ $detail->Quantity }}</td>
                <td>{{ number_format($detail->UnitPrice, 0, ',', '.') }} VND</td>
                <td>{{ number_format($detail->UnitPrice * $detail->Quantity, 0, ',', '.') }} VND</td>
            </tr>
            @endforeach

        </tbody>
    </table>

    <a href="{{ route('admin.orders.details') }}" class="btn btn-secondary">Quay lại danh sách</a>
</div>
@endsection
