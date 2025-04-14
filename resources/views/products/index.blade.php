<!-- resources/views/products/index.blade.php -->
@extends('layouts.admin')

@section('content')
<style>
/* Giảm kích thước mũi tên phân trang */
.pagination {
    display: flex;
    justify-content: center;
    align-items: center; /* Căn giữa dọc */
    gap: 4px; /* Khoảng cách giữa các phần tử */
    margin-top: 20px; /* Khoảng cách trên */
}

.page-item {
    list-style: none; /* Bỏ dấu chấm của danh sách */
}

.page-link {
    padding: 4px 8px; /* Thay đổi padding cho nhỏ gọn hơn */
    border: 1px solid #ccc; /* Biên cho các nút */
    border-radius: 4px; /* Bo góc */
    text-decoration: none; /* Bỏ gạch chân */
    color: #333; /* Màu chữ */
    font-size: 12px; /* Kích thước chữ cho tất cả các phần tử */
    transition: background-color 0.2s; /* Hiệu ứng chuyển màu */
}

.page-link:hover {
    background-color: #f0f0f0; /* Màu nền khi hover */
}

.active .page-link {
    background-color: #007bff; /* Màu nền cho trang đang hoạt động */
    color: #fff; /* Màu chữ cho trang đang hoạt động */
}

.disabled .page-link {
    color: #ccc; /* Màu chữ cho các nút vô hiệu */
    cursor: not-allowed; /* Thay đổi con trỏ */
}



</style>
<div class="container mt-5">
    <h1 class="text-center">Quản lý Sản phẩm</h1>
    <!-- Form tìm kiếm -->
    <form action="{{ route('products.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm" value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
        </div>
    </form>
    <!-- Hiển thị thông báo thành công -->
    @if (session('success'))
    <div class="alert alert-success" id="success-message"> <!-- ID này cần phải khớp -->
        {{ session('success') }}
    </div>
@endif
    <a href="{{ route('products.create') }}" class="btn btn-success mb-3">Thêm sản phẩm</a>

    <hr>

    <!-- Liệt kê sản phẩm -->
    <h3>Danh sách Sản phẩm</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Sản phẩm</th>
                <th>Mô tả</th>
                <th>Giá</th>
                <th>Số lượng tồn kho</th>
                <th>Danh mục</th>
                <th>Ảnh</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->ProductID }}</td>
                    <td>{{ $product->ProductName }}</td>
                    <td>{{ $product->Description }}</td>
                    <td>{{ $product->Price }}</td>
                    <td>
                        <form action="{{ route('products.updateStock', $product->ProductID) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="number" name="stock" value="{{ $product->Stock }}" required>
                            <button type="submit" class="btn btn-primary btn-sm">Cập nhật tồn kho</button>
                        </form>
                    </td>
                    <td>{{ $product->category ? $product->category->CatalogName : 'Không có danh mục' }}</td>
                    <td><img src="{{ asset('image/' . $product->ImageURL) }}" width="100" alt="Hình ảnh sản phẩm"></td>
                    <td>
                        <!-- Nút Sửa -->
                        <a href="{{ route('products.edit', $product->ProductID) }}" class="btn btn-warning btn-sm">Sửa</a>

                        <!-- Nút Xóa -->
                        <form action="{{ route('products.destroy', $product->ProductID) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
 <!-- Phân trang -->
 <div class="d-flex justify-content-center">
    {{ $products->links('vendor.pagination.custom') }} <!-- Gọi phân trang -->
</div>

</div>
<script>
    // Kiểm tra xem thông báo có hiển thị không
    const successMessage = document.getElementById('success-message');
    if (successMessage) {
        // Sau 3 giây, ẩn thông báo
        setTimeout(() => {
            successMessage.style.display = 'none';
        }, 3000); // Thời gian 3000ms = 3 giây
    }
</script>
@endsection
