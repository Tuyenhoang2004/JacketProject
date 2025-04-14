@extends('layouts.app')

@section('content')
@include('layouts.menu')

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Thanh Toán</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* Các kiểu CSS của bạn */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .checkout-button {
            display: block;
            width: 100%;
            background-color: #ffc107;
            color: #000;
            padding: 12px;
            border: none;
            border-radius: 5px;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .checkout-button:hover {
            background-color: #e0a800;
        }
        .alert {
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: bold;
            text-align: center;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>THANH TOÁN</h1>

        {{-- Thông báo thành công --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Thông báo lỗi --}}
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Giỏ hàng --}}
        @if (!empty($cart))
            <table class="table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $item)
                        <tr>
                            <td>{{ $item['product_name'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ number_format($item['price_after_discount']) }}đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Tổng tiền --}}
            <h3>Tổng tiền: {{ number_format($total) }}đ</h3>
            {{-- Form nhập thông tin giao hàng --}}
@if (!$hideForm)
    <div style="background-color: #ffe6e6; border-radius: 12px; padding: 30px; max-width: 600px; margin: 30px auto; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <form method="POST" action="{{ route('checkout.confirmShipping') }}">
            @csrf

            <h4 style="text-align: center; margin-bottom: 25px; color: #cc3366;">Thông tin giao hàng</h4>

            <div style="margin-bottom: 15px;">
                <label for="customer_name" style="font-weight: bold;">Tên người nhận</label>
                <input type="text" class="form-control" name="customer_name" id="customer_name" 
                       placeholder="Tên người nhận" required 
                       style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="address" style="font-weight: bold;">Địa chỉ giao hàng</label>
                <input type="text" class="form-control" name="address" id="address" 
                       placeholder="Địa chỉ giao hàng" required 
                       style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="phone" style="font-weight: bold;">Số điện thoại</label>
                <input type="text" class="form-control" name="phone" id="phone" 
                       placeholder="Số điện thoại" required 
                       style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">
            </div>

            <div style="margin-bottom: 20px;">
                <label for="note" style="font-weight: bold;">Ghi chú</label>
                <textarea class="form-control" name="note" id="note" placeholder="Ghi chú" rows="4"
                          style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;"></textarea>
            </div>

            <button type="submit" style="width: 100%; background-color: #ff6699; color: white; padding: 12px; border: none; border-radius: 8px; font-weight: bold;">
                Lưu thông tin và tiếp tục thanh toán
            </button>
        </form>
    </div>



            @else
                {{-- Form thanh toán khi thông tin giao hàng đã được xác nhận --}}
                <form method="POST" action="{{ route('checkout.processPayment') }}">
                    @csrf
                    <button type="submit" class="btn btn-success checkout-button">Thanh toán</button>
                </form>
            @endif
        @else
            <div class="alert alert-danger">Giỏ hàng của bạn hiện tại trống!</div>
        @endif
    </div>
</body>
</html>
@endsection