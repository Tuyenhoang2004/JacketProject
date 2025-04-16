@extends('layouts.app')

@section('content')
@include('layouts.menu')

<style>
    body {
        background-color: #f4f4f4;
    }
    .container {
        width: 95%;
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
    .qr-container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    height: 100vh; 
    text-align: center;
    }

    .qr-code img {
        max-width: 70%; 
        height: auto; 
        display: block;
        margin-top: 20px;
        text-align: center;
    }

    #qr-code-momo, #qr-code-bank {
        display: none; 
    }
    h3{
        text-align: right;
    }


</style>

<div class="container">
    <h1><b>XÁC NHẬN ĐẶT HÀNG</b></h1>

    {{-- Thông báo --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if (!empty($cart))
        <table>
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

        <h3><b>Tổng tiền: {{ number_format($total) }}đ</b></h3>

        @if (!$hideForm)
            {{-- Form nhập thông tin giao hàng --}}
            <div style="background-color: #ffe6e6; border-radius: 12px; padding: 30px; max-width: 600px; margin: 30px auto;">
            @php
                $user = Auth::user();
                $userName = $user->UserName ?? '';
                $userAddress = $user->UserAddress ?? '';
                $userPhone = $user->UserPhone ?? '';
            @endphp


                <form method="POST" action="{{ route('checkout.confirmShipping') }}">
                    @csrf
                    <h4 style="text-align: center; margin-bottom: 25px; color: #cc3366;">Thông tin giao hàng</h4>

                    <div style="margin-bottom: 15px;">
                        <label for="customer_name"><strong>Tên người nhận</strong></label>
                        <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name', $user->UserName) }}" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label for="address"><strong>Địa chỉ giao hàng</strong></label>
                        <input type="text" name="address" id="address" value="{{ old('address', $user->UserAddress) }}" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label for="phone"><strong>Số điện thoại</strong></label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->UserPhone) }}" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label for="note"><strong>Ghi chú</strong></label>
                        <textarea name="note" id="note" rows="4" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc;">{{ old('note') }}</textarea>
                    </div>
                    <button type="submit" style="width: 100%; background-color: #ff6699; color: white; padding: 12px; border: none; border-radius: 8px; font-weight: bold;">
                        Lưu thông tin và tiếp tục thanh toán
                    </button>
                </form>
            </div>
        @else
        <form method="POST" action="{{ route('checkout.processPayment') }}">
            @csrf
    <div class="form-group">
        <label><b>Phương thức thanh toán:</b></label><br>
        <label><input type="radio" name="payment_method" value="cod" required> Thanh toán khi nhận hàng (COD)</label><br>
        <label><input type="radio" name="payment_method" value="momo"> MoMo</label><br>
        <label><input type="radio" name="payment_method" value="bank_transfer"> Chuyển khoản ngân hàng</label>
    </div>

    <!-- QR Codes -->
    <div id="qr-code-momo" style="display: none; margin-top: 10px;">
        <img src="{{ asset('image/qrcode_momo.jpg') }}" alt="QR MoMo">
    </div>

    <div id="qr-code-bank" style="display: none; margin-top: 10px;">
        <img src="{{ asset('image/qrcode_bank.jpg') }}" alt="QR Chuyển khoản">
    </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const radios = document.querySelectorAll('input[name="payment_method"]');

                radios.forEach(function (radio) {
                    radio.addEventListener('change', function () {
                        const momoQR = document.getElementById('qr-code-momo');
                        const bankQR = document.getElementById('qr-code-bank');

                        momoQR.style.display = 'none';
                        bankQR.style.display = 'none';

                        if (this.value === 'momo') {
                            momoQR.style.display = 'block';
                        } else if (this.value === 'bank_transfer') {
                            bankQR.style.display = 'block';
                        }
                    });
                });
            });
        </script>

            <br>
            <button type="submit" class="checkout-button">Xác nhận đặt hàng</button>
        </form>
        @endif
    @else
        <div class="alert alert-danger">Giỏ hàng của bạn hiện tại trống!</div>
    @endif
</div>
@endsection
