@extends('layouts.admin')

@section('title', '📊 Thống kê Đơn hàng')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center fw-bold">📊 Thống kê Đơn hàng</h2>
    <form method="GET" class="row justify-content-center mb-4">
        <div class="col-md-3">
            <label for="from_date" class="form-label">Từ ngày:</label>
            <input type="date" id="from_date" name="from_date" class="form-control"
                value="{{ request('from_date') }}">
        </div>
        <div class="col-md-3">
            <label for="to_date" class="form-label">Đến ngày:</label>
            <input type="date" id="to_date" name="to_date" class="form-control"
                value="{{ request('to_date') }}">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Lọc</button>
        </div>
    </form>


    <div class="row justify-content-center">
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg border-0 p-3 stat-card bg-gradient-primary text-white">
                <div class="d-flex align-items-center">
                    <i class="bi bi-bag-check-fill fs-1 me-3"></i>
                    <div>
                        <h5 class="mb-1">Tổng đơn hàng</h5>
                        <p class="fs-4 mb-0 fw-bold">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-lg border-0 p-3 stat-card bg-gradient-success text-white">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check2-circle fs-1 me-3"></i>
                    <div>
                        <h5 class="mb-1">Đơn hoàn thành</h5>
                        <p class="fs-4 mb-0 fw-bold">{{ $completedOrders }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-lg border-0 p-3 stat-card bg-gradient-danger text-white">
                <div class="d-flex align-items-center">
                    <i class="bi bi-x-circle-fill fs-1 me-3"></i>
                    <div>
                        <h5 class="mb-1">Đơn bị huỷ</h5>
                        <p class="fs-4 mb-0 fw-bold">{{ $cancelledOrders }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-lg border-0 p-3 stat-card bg-gradient-warning text-dark">
                <div class="d-flex align-items-center">
                    <i class="bi bi-cash-stack fs-1 me-3"></i>
                    <div>
                        <h5 class="mb-1">Tổng doanh thu</h5>
                        <p class="fs-5 mb-0 fw-bold">{{ number_format($totalRevenue, 0, ',', '.') }} VND</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Biểu đồ tròn --}}
    <div class="mt-5 text-center">
        <h4 class="mb-4">🟡 Tỷ lệ đơn hàng</h4>
        <div style="max-width: 600px; margin: 0 auto;">
            <canvas id="orderPieChart"></canvas>
        </div>
    </div>
</div>


{{-- Script cho Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const completed = @json($completedOrders);
        const cancelled = @json($cancelledOrders);
        const others = @json($totalOrders - $completedOrders - $cancelledOrders);

        const ctx = document.getElementById('orderPieChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Hoàn thành', 'Đã huỷ', 'Chờ xử lý'],
                datasets: [{
                    data: [completed, cancelled, others],
                    backgroundColor: ['#28a745', '#dc3545', '#ffc107'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'bottom' },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = completed + cancelled + others;
                                const percentage = total ? ((value / total) * 100).toFixed(1) : 0;
                                return `${label}: ${value} đơn (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>


<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #1f1c2c, #928dab); /* tím khói đẹp chill */
    color: #fff;
}

.bg-gradient-success {
    background: linear-gradient(135deg, #11998e, #38ef7d); /* xanh ngọc neon */
    color: #fff;
}

.bg-gradient-danger {
    background: linear-gradient(135deg, #f953c6, #b91d73); /* hồng tím đậm chất dev */
    color: #fff;
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #f7971e, #ffd200); /* vàng cam tech-style */
    color: #212529;
}


    .stat-card:hover {
        transform: translateY(-3px);
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    
</style>
@endsection
