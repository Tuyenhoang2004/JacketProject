@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $product->ProductName }}</h1>
    <p><strong>Mô tả:</strong> {{ $product->Description }}</p>
    <p><strong>Giá:</strong> {{ number_format($product->Price, 0, ',', '.') }} VNĐ</p>
    <p><strong>Số lượng tồn kho:</strong> {{ $product->Stock }}</p>
    <p><strong>Danh mục:</strong> {{ $product->category->CatalogName }}</p>
    @if($product->ImageURL)
    <img src="{{ asset('storage/' . $product->ImageURL) }}" alt="{{ $product->ProductName }}">
     @else
    <p>Không có hình ảnh.</p>
    @endif
    <a href="{{ route('products.edit', $product->ProductID) }}" class="btn btn-warning">Sửa sản phẩm</a>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Quay lại</a>
</div>
@endsection
