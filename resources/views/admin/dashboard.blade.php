@extends('layouts.admin')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@section('title', 'Admin Dashboard')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Welcome Section -->


<!-- Navbar -->
<div class="menu">
    <ul>
        <li><a href="{{ url('admin/dashboard') }}">Thống kê</a></li>
        <li><a href="{{ url('products') }}">Quản lý Sản phẩm</a></li>
        <li class="order-menu">
            <a href="#">Quản lý Đơn hàng</a>
            <ul class="dropdown-menu">
            <li><a href="{{ route('admin.orders.order-statistics') }}">Thống kê đơn hàng</a></li>
            <li><a href="{{ route('admin.orders.details') }}">Thông tin đơn hàng</a></li>
            </ul>
        </li>
        <li><a href="{{ route('user.index') }}">Quản lý Người dùng</a></li>
        <li class="user-menu">
            <a href="#" class="fa fa-user" onclick="return false;"></a>
            <ul class="dropdown-menu">
                @if(Auth::check())
                    <li style="padding: 8px 15px; font-weight: bold;">
                        Hello, {{ Auth::user()->UserName }}
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="logout-btn">Đăng xuất</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">Đăng nhập</a></li>
                    <li><a href="{{ route('register') }}">Đăng ký</a></li>
                @endif
            </ul>

        </li>
    </ul>
</div>
<br>
<h2 class="text-center mb-4">Thống kê hệ thống bán hàng</h2>
<div class="container">
<div class="row g-4">
    <div class="col-md-3">
        <div class="stat-card bg-soft-blue">
            <div class="stat-icon"><i class="bi bi-bag-check-fill"></i></div>
            <h5>Tổng đơn hàng</h5>
            <p class="fs-4">{{ $totalOrders }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card bg-soft-green">
            <div class="stat-icon"><i class="bi bi-currency-dollar"></i></div>
            <h5>Tổng doanh thu</h5>
            <p class="fs-4">{{ number_format($totalRevenue, 0, ',', '.') }}₫</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card bg-soft-yellow">
            <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
            <h5>Người dùng</h5>
            <p class="fs-4">{{ $totalUsers }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card bg-soft-pink">
            <div class="stat-icon"><i class="bi bi-box-seam"></i></div>
            <h5>Sản phẩm</h5>
            <p class="fs-4">{{ $totalProducts }}</p>
        </div>
    </div>
</div>
</div>
    <div class="row mt-5">
        <div class="col-md-12">
            <canvas id="revenueChart" height="100"></canvas>
        </div>
    </div>
</div>

<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
        color: #333;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .text-center {
        text-align: center;
    }

    .menu {
        background-color: #333;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 30px;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .menu ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        gap: 20px;
    }

    .menu li {
        padding: 0;
    }

    .menu a {
        text-decoration: none;
        color: white;
        font-weight: bold;
        transition: 0.3s;
        padding: 10px 15px;
        border-radius: 5px;
        display: block;
    }

    .menu a:hover {
        background-color:rgb(252, 5, 141);
        color: #333;
    }

    .user-menu, .order-menu {
        position: relative;
    }

    .user-menu .dropdown-menu, .order-menu .dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        padding: 10px 0;
        list-style: none;
        min-width: 150px;
        z-index: 999;
    }

    .user-menu:hover .dropdown-menu, .order-menu:hover .dropdown-menu {
        display: block;
    }

    .user-menu .dropdown-menu li, .order-menu .dropdown-menu li {
        padding: 8px 16px;
    }

    .user-menu .dropdown-menu li a, .order-menu .dropdown-menu li a {
        text-decoration: none;
        color: black;
        display: block;
    }

    .user-menu .dropdown-menu li a:hover, .order-menu .dropdown-menu li a:hover {
        background-color: #f0f0f0;
    }

    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }

    .item {
        background-color: #fff;
        text-align: center;
        padding: 20px;
        border-radius: 15px;
        border: 1px solid #ddd;
        transition: transform 0.3s, box-shadow 0.3s;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .item:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .item p {
        font-size: 16px;
        color: #333;
        margin-bottom: 10px;
    }

    .item a {
        text-decoration: none;
        color: black;
        font-weight: bold;
    }

    .price {
        color: #f00;
        font-weight: bold;
        font-size: 18px;
        margin-top: 10px;
    }
    .stat-card {
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        padding: 20px;
        color: #333;
        text-align: center;
        height: 150px; /* Hoặc điều chỉnh chiều cao tuỳ thích */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        border: 2px solid black;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .stat-icon {
        font-size: 2rem;
        margin-bottom: 10px;
        display: inline-block;
    }

    .fs-4 {
        font-weight: bold;
        font-size: 1.75rem;
    }

    .bg-soft-blue {
        background-color: #d0ebff;
    }

    .bg-soft-green {
        background-color: #d3f9d8;
    }

    .bg-soft-yellow {
        background-color: #fff3bf;
    }

    .bg-soft-pink {
        background-color: #ffdce0;
    }

</style>
<form method="GET" action="{{ route('admin.dashboard') }}" class="d-flex justify-content-end align-items-center mb-3">
    <label for="year" class="me-2 fw-bold">Chọn năm:</label>
    <select name="year" id="year" class="form-select w-auto" onchange="this.form.submit()">
        @foreach ($years as $year)
            <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
        @endforeach
    </select>
</form>

<h4 class="text-center mb-4">Biểu đồ doanh thu theo tháng</h4>
<hr style="border: none; height: 4px; background: linear-gradient(to right, #4e54c8, #8f94fb); border-radius: 4px; margin: 30px 0;">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($doanhThuLabels) !!},
            datasets: [{
                label: 'Doanh thu theo tháng (₫)',
                data: {!! json_encode($doanhThuData) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => value.toLocaleString('vi-VN') + '₫'
                    }
                }
            }
        }
    });
</script>
<!-- Top Products Cards -->
<div class="mt-5">
    <h2 class="text-center mb-4">Top 5 Sản Phẩm Bán Chạy</h2>
    <div class="row justify-content-center">
        <!-- 3 sản phẩm trên -->
        @foreach($topProducts->take(3) as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0 rounded-4">
                    <div class="card-img-wrapper">
                        <img src="{{ asset('image/' . $product->image_url) }}"
                             class="card-img-top rounded-top-4"
                             alt="{{ $product->name }}"
                             style="width: 100%; height: 200px; object-fit: cover;">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title mb-2">{{ $product->name }}</h5>
                        <p class="text-muted mb-0">Đã bán: <strong>{{ $product->sold_quantity }}</strong></p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row justify-content-center mt-4">
        <!-- 2 sản phẩm dưới -->
        @foreach($topProducts->skip(3)->take(2) as $product)
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0 rounded-4">
                    <div class="card-img-wrapper">
                        <img src="{{ asset('image/' . $product->image_url) }}"
                             class="card-img-top rounded-top-4"
                             alt="{{ $product->name }}"
                             style="width: 100%; height: 200px; object-fit: cover;">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title mb-2">{{ $product->name }}</h5>
                        <p class="text-muted mb-0">Đã bán: <strong>{{ $product->sold_quantity }}</strong></p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>



</div>


<!-- Top Users -->
<div class="mt-5">
    <h2 class="text-center mb-4">Top 5 Người Dùng Mua Hàng Nhiều Nhất</h2>
    <div class="row justify-content-center">
        @foreach ($topUsers as $user)
            <div class="col-md-4 col-lg-3 mb-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <h5 class="card-title">{{ $user->UserName }}</h5>
                        <p class="card-text text-muted">Tổng đơn: {{ $user->TotalOrders }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- ChartJS script for Top Products -->
<script>
    const topProducts = @json($topProducts);

    const labels = topProducts.map(p => p.ProductName);
    const data = topProducts.map(p => p.total_sales);

    const topProductsCtx = document.getElementById('topProductsChart').getContext('2d');
    new Chart(topProductsCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Số lượng bán',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Số lượng'
                    }
                }
            }
        }
    });
</script>


@endsection
