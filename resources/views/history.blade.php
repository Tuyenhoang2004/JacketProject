@extends('layouts.app')

@section('content')
@include('layouts.menu')
<style>
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }

    .btn-outline-success:hover {
        background-color: #28a745;
        color: #fff;
    }
    .btn-lg {
        font-size: 16px;
        padding: 10px 20px;
        font-weight: bold;
        border-radius: 8px;
    }

    .btn-danger:hover {
        background-color: #c82333;
        box-shadow: 0 0 10px rgba(255, 0, 0, 0.4);
    }

    .btn-success:hover {
        background-color: #218838;
        box-shadow: 0 0 10px rgba(0, 255, 0, 0.4);
    }
    .btn-sm {
        font-size: 14px;
        padding: 6px 14px;
        font-weight: 500;
        border-radius: 6px;
    }
    .table-history {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }

    .table-history th {
        background-color: #f8f9fa;
        color: #495057;
        text-align: center;
        vertical-align: middle;
    }

    .table-history td {
        vertical-align: middle;
        text-align: center;
    }

    .table-history img {
        border-radius: 8px;
    }

    .table-history tbody tr:hover {
        background-color: #f1f1f1;
    }

    .btn-action {
        width: 140px;
        margin: 2px 0;
    }

    .status-badge {
        font-size: 0.9rem;
        padding: 6px 10px;
        border-radius: 8px;
    }

    .status-hoanthanh {
        background-color: #d1e7dd;
        color: #0f5132;
    }

    .status-huy {
        background-color: #f8d7da;
        color: #842029;
    }

    .status-default {
        background-color: #000;
        color: #41464b;
    }
    .badge {
        color:#000;
    }
</style>

</style>
<div class="container">
    <h1>Lịch Sử Mua Hàng</h1>

    @if ($orders->isEmpty())
        <div class="alert alert-warning">Bạn chưa có đơn hàng nào.</div>
    @else
    <table class="table table-bordered table-striped table-history">

            <thead>
                <tr>
                    <th>Tên Sản Phẩm</th>
                    <th>Hình Ảnh</th>
                    <th>Ngày Đặt Hàng</th>
                    <th>Tổng Tiền</th>
                    <th>Trạng Thái</th>
                    <th>Địa Chỉ Giao Hàng</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($orders as $order)
    <tr>
        {{-- Kiểm tra nếu đơn hàng có sản phẩm --}}
        @if ($order->products->isNotEmpty())
            <td>
                @foreach ($order->products as $product)
                <div>{{ $product->ProductName ?? 'Sản phẩm đã bị xóa' }}</div>
                @endforeach
            </td>
            <td>
                @foreach ($order->products as $product)
                <img src="{{ asset('image/' . $product->ImageURL) }}" width="100" alt="Hình ảnh sản phẩm">
                @endforeach
            </td>
        @else
            <td>Không có sản phẩm</td>
            <td>Không có hình ảnh</td>
        @endif

        <td>{{ $order->OrderDate->format('d/m/Y') }}</td>
        <td>{{ number_format($order->TotalAmount) }}đ</td>
        <td>{{ $order->StatusOrders }}</td>
        <td>{{ $order->user->UserAddress ?? 'Không có địa chỉ' }}</td>
        <td>
        @if ($order->StatusOrders == 'Đã hủy')
            <span class="badge badge-danger">Không thể thao tác</span>
        @elseif ($order->StatusOrders == 'Hoàn thành')
            <span class="badge badge-success">Không thể thao tác</span>
        @else
        <form action="{{ route('order.updateStatus', [$order->OrderID, 'Đã hủy']) }}" method="POST" style="display:inline-block; margin-right: 8px;">
    @csrf
    <button type="submit" class="btn btn-outline-danger btn-sm" style="min-width: 110px;">
        <i class="fa fa-times-circle"></i> Hủy đơn
    </button>
</form>

<form action="{{ route('order.updateStatus', [$order->OrderID, 'Hoàn thành']) }}" method="POST" style="display:inline-block;">
    @csrf
    <button type="submit" class="btn btn-outline-success btn-sm" style="min-width: 130px;">
        <i class="fa fa-check-circle"></i> Đã nhận
    </button>
</form>



        @endif

        </td>
    </tr>
@endforeach

            </tbody>
        </table>
    @endif
</div>

@endsection
