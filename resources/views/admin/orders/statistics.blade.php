@extends('layouts.app')

@section('title', 'Thống kê đơn hàng')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-5">Thống kê Đơn Hàng</h1>

    {{-- Top Products Chart --}}
    <div class="mb-5">
        <h2 class="text-center mb-4">Top 5 Sản Phẩm Bán Chạy</h2>
        <div class="bg-white p-4 rounded shadow">
            <canvas id="topProductsChart" height="120"></canvas>
        </div>
    </div>

    {{-- Top Users --}}
    <div class="mb-5">
        <h2 class="text-center mb-4">Top 5 Người Dùng Mua Hàng Nhiều Nhất</h2>
        <div class="row">
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
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const topProducts = @json($topProducts);

    const labels = topProducts.map(p => p.ProductName);
    const data = topProducts.map(p => p.total_sales);

    const ctx = document.getElementById('topProductsChart').getContext('2d');
    new Chart(ctx, {
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
