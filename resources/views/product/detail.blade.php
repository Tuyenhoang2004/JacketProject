@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@include('layouts.menu') {{-- Sử dụng header đã tạo --}}
<br>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


<style>
    body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            max-width: 2000px;
            margin: 0 auto;
            padding: 10px;
        }

    .container {
        max-width: 1500px;
        margin: 0 auto;
        padding: 10px;
    }

    .product-detail-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        background-color: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .product-image img {
        width: 100%;
        height: auto;
        border-radius: 10px;
        object-fit: cover;
    }

    .product-info h2 {
        font-size: 2rem;
        margin-bottom: 15px;
        color: #222;
    }

    .product-info p {
        margin: 10px 0;
        font-size: 1.1rem;
    }

    .price {
        color: #e74c3c;
        font-weight: bold;
        font-size: 1.3rem;
    }

    .product-options {
        margin-top: 15px;
    }

    .product-options label {
        font-weight: bold;
    }

    .size-options label {
        margin-right: 15px;
    }

    .quantity-input {
        width: 60px;
        padding: 5px;
        text-align: center;
        margin-left: 10px;
    }

    .btn-primary {
        background-color: rgb(252, 5, 141);
        color: black;
        border: none;
        padding: 10px 20px;
        margin-top: 15px;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover{
        background-color: rgb(252, 5, 141);
        color: white;
    }

    .product-description {
        background-color: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
    }

    .product-description h4 {
        margin-bottom: 15px;
        color: #333;
    }

    .btn-review {
        display: inline-block;
        background-color: #2334ce;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        transition: 0.3s;
        margin-bottom: 20px;
    }

    .btn-review:hover {
        background-color: rgb(252, 5, 141);
        color: black;
    }

    .reviews-container {
        background-color: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .review-item {
        margin-bottom: 20px;
    }

    .review-item .rating {
        color: #FFBA28;
        font-size: 1.2rem;
    }

    .review-item p {
        margin: 5px 0;
    }

    .review-item strong {
        color: #000;
    }

</style>

<div class="container">
    @if($product)
        <div class="product-detail-container">
            <div class="product-image">
                <img src="{{ asset('image/' . $product->ImageURL) }}" alt="{{ $product->ProductName }}">
            </div>
            <div class="product-info">
                <h2>{{ $product->ProductName }}</h2>
                <p><b>Tồn kho:</b> {{ $product->Stock }}</p>
                <p><b>Giảm giá:</b> {{ $product->DiscountValue }}%</p>
                <p><b>Giá gốc:</b> <span class="price">{{ number_format($product->Price, 0, ",", ".") }} VNĐ</span></p>

                <form method="POST" action="{{ route('cart.add') }}" class="product-options">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->ProductID }}">
                    <input type="hidden" name="product_name" value="{{ $product->ProductName }}">
                    <input type="hidden" name="price" value="{{ $product->Price }}">
                    <input type="hidden" name="discountValue" value="{{ $product->DiscountValue }}">

                    <label>Chọn size:</label>
                    <div class="size-options">
                        <input type="radio" id="size_s" name="size" value="S" required><label for="size_s">S</label>
                        <input type="radio" id="size_m" name="size" value="M"><label for="size_m">M</label>
                        <input type="radio" id="size_l" name="size" value="L"><label for="size_l">L</label>
                        <input type="radio" id="size_xl" name="size" value="XL"><label for="size_xl">XL</label>
                    </div>

                    <label for="quantity">Số lượng:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" class="quantity-input">

                    <button type="submit" name="add_to_cart" class="btn-primary">Thêm vào giỏ hàng</button>
                </form>
            </div>
        </div>

        <div class="product-description">
            <h4>Mô tả sản phẩm</h4>
            <p>{{ $product->Description }}</p>
        </div>
        

        @if(count($reviews) > 0)
            <div class="reviews-container">
                @foreach($reviews as $review)
                    <div class="review-item">
                        <!-- Hiển thị tên người dùng -->
                         
                        <p><strong>{{ $review->user->UserName ?? 'Người dùng' }}</strong>
                        - {{ \Carbon\Carbon::parse($review->ReviewDate)->format('d/m/Y') }}</p>
                        
                        <!-- Hiển thị đánh giá sao -->
                        <p class="rating">
                            {!! str_repeat('★', $review->Rating) . str_repeat('☆', 5 - $review->Rating) !!}
                        </p>
                        
                        <!-- Hiển thị nhận xét -->
                        <p><strong>Nhận xét:</strong> {!! nl2br(e($review->Comment)) !!}</p>
                    </div>
                    <hr>
                @endforeach
            </div>
        @else
            <p>Chưa có đánh giá cho sản phẩm này.</p>
        @endif

    @endif
</div>
@endsection
