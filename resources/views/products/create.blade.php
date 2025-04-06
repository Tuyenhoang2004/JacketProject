@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h1>Thêm Sản phẩm</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Tên sản phẩm -->
        <div class="mb-3">
            <label for="name" class="form-label">Tên sản phẩm</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" required>
        </div>

        <!-- Mô tả sản phẩm -->
        <div class="mb-3">
            <label for="description" class="form-label">Mô tả sản phẩm</label>
            <textarea name="description" class="form-control" id="description" required>{{ old('description') }}</textarea>
        </div>

        <!-- Giá sản phẩm -->
        <div class="mb-3">
            <label for="price" class="form-label">Giá sản phẩm</label>
            <input type="number" name="price" class="form-control" id="price" value="{{ old('price') }}" required>
        </div>

        <!-- Số lượng tồn kho -->
        <div class="mb-3">
            <label for="quantity" class="form-label">Số lượng tồn kho</label>
            <input type="number" name="quantity" class="form-control" id="quantity" value="{{ old('quantity') }}" required>
        </div>

        <!-- Chọn danh mục -->
        <div class="mb-3">
            <label for="category" class="form-label">Danh mục</label>
            <select name="category_id" class="form-control" id="category" required>
                <option value="">Chọn danh mục</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->CatalogID }}" {{ old('category_id') == $category->CatalogID ? 'selected' : '' }}>
                        {{ $category->CatalogName }}
                    </option>
                @endforeach
        </select>

        </div>

        <!-- Hình ảnh sản phẩm -->
         
        <div class="mb-3">
            <label for="image" class="form-label">Hình ảnh sản phẩm</label>
            <input type="file" name="image" class="form-control" id="image" accept="image/*">
            <small class="form-text text-muted">Kích thước tối đa 2MB. Chỉ chấp nhận định dạng JPG, PNG.</small>
        </div>

        <button type="submit" class="btn btn-primary">Thêm Sản phẩm</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection
