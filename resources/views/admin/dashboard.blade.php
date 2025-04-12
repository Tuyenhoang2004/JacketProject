@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Welcome Section -->
<div class="container mt-5">
    <h1 class="text-center mb-2">Welcome to Admin Dashboard</h1>
</div>

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
            @if(Session::has('UserPhone'))
                <a href="#" class="fa fa-user"></a>
                <ul class="dropdown-menu">
                    <li>Xin chào {{ Session::get('UserName') }}!</li>
                    <li><a href="{{ url('logout') }}">Đăng xuất</a></li>
                </ul>
            @else
                <a href="#" class="fa fa-user"></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('signin') }}">Đăng nhập</a></li>
                    <li><a href="{{ url('signup') }}">Đăng ký</a></li>
                </ul>
            @endif
        </li>
    </ul>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5>Tổng đơn hàng</h5>
                    <p class="fs-4">{{ $totalOrders }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5>Tổng doanh thu</h5>
                    <p class="fs-4">{{ number_format($totalRevenue, 0, ',', '.') }}₫</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5>Người dùng</h5>
                    <p class="fs-4">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5>Sản phẩm</h5>
                    <p class="fs-4">{{ $totalProducts }}</p>
                </div>
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
    .card-title {
    font-size: 1.1rem;
    font-weight: 600;
}

.card img {
    transition: transform 0.3s ease;
}

.card:hover img {
    transform: scale(1.05);
}

</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<canvas id="revenueChart"></canvas>
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
        @foreach($topProducts as $product)
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm border-0 rounded-4">
                    <img src="{{ asset('image/' . $product->image_url) }}"
                         class="card-img-top rounded-top-4"
                         alt="{{ $product->name }}"
                         style="height: 200px; object-fit: cover;">
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
