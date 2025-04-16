@extends('layouts.app')

@section('content')
@include('layouts.menu')

@if(session('warning'))
    <div class="alert alert-warning">
        {{ session('warning') }}
    </div>
@endif

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
        color: #000;
    }
</style>

<div class="container">
    <h1><b>Lịch Sử Mua Hàng</b></h1>

    @if ($orders->isEmpty())
        <div class="alert alert-warning">🛒 Bạn chưa có đơn hàng nào. Hãy bắt đầu mua sắm thôi!</div>
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
        {{-- Tên sản phẩm --}}
        <td>
            @forelse ($order->products as $product)
                <div>{{ $product->ProductName ?? 'Sản phẩm đã bị xóa' }}</div>
            @empty
                Không có sản phẩm
            @endforelse
        </td>

        {{-- Hình ảnh --}}
        <td>
            @forelse ($order->products as $product)
                <img src="{{ asset('image/' . $product->ImageURL) }}" width="100" alt="Hình ảnh sản phẩm">
            @empty
                Không có hình ảnh
            @endforelse
        </td>

        {{-- Ngày đặt --}}
        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</td>

        {{-- Tổng tiền --}}
        <td>{{ number_format($order->TotalAmount) }}đ</td>

        {{-- Trạng thái --}}
        <td>{{ $order->StatusOrders }}</td>

        {{-- Địa chỉ --}}
        <td>{{ $order->user->UserAddress ?? 'Không có địa chỉ' }}</td>

        {{-- Thao tác --}}
        <td>
            @if ($order->StatusOrders == 'Đã hủy')
                <span class="badge badge-danger">Không thể thao tác</span>
            @elseif ($order->StatusOrders == 'Hoàn thành')
                        <div class="mb-1">Vui lòng đánh giá sản phẩm</div>
                        <a href="{{ route('review.create', ['ProductID' => $product->ProductID, 'back_url' => url()->current()]) }}"
                           class="btn btn-warning btn-sm mb-2">
                            Đánh giá
                        </a>
            @else
                <form action="{{ route('order.updateStatus', [$order->OrderID, 'Đã hủy']) }}" method="POST" style="display:inline-block; margin-bottom: 6px;">
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
