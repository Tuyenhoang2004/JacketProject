@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Sửa Sản phẩm</h1>
    <form action="{{ route('products.update', $product->ProductID) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Tên sản phẩm -->
        <div class="mb-3">
            <label for="name" class="form-label">Tên sản phẩm</label>
            <input type="text" name="name" class="form-control" value="{{ $product->ProductName }}" required>
        </div>

        <!-- Mô tả sản phẩm -->
        <div class="mb-3">
            <label for="description" class="form-label">Mô tả sản phẩm</label>
            <textarea name="description" class="form-control" required>{{ $product->Description }}</textarea>
        </div>

        <!-- Giá sản phẩm -->
        <div class="mb-3">
            <label for="price" class="form-label">Giá sản phẩm</label>
            <input type="number" name="price" class="form-control" value="{{ $product->Price }}" required>
        </div>

        <!-- Số lượng tồn kho -->
        <div class="mb-3">
            <label for="quantity" class="form-label">Số lượng tồn kho</label>
            <input type="number" name="quantity" class="form-control" value="{{ $product->Stock }}" required>
        </div>

        <!-- Chọn danh mục -->
        <div class="mb-3">
            <label for="category" class="form-label">Danh mục</label>
            <select name="category_id" class="form-control" required>
                @foreach ($categories as $category)
                    <option value="{{ $category->CatalogID }}" {{ $category->CatalogID == $product->CategoryID ? 'selected' : '' }}>
                        {{ $category->CatalogName }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Nút Lưu -->
        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
