@extends('layouts.admin')

@section('title', 'Thông tin đơn hàng')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-3">Thông tin đơn hàng</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <style>
        h1 {
            font-weight: bold;
            color: #333;
        }
        table th {
            background-color: #343a40;
            color: white;
        }
        td {
            vertical-align: middle;
        }
        .badge-status {
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .pending {
            background-color: #ffe58f;
            color: #ad8b00;
        }
        .completed {
            background-color: #b7eb8f;
            color: #389e0d;
        }
        .cancelled {
            background-color: #ffa39e;
            color: #cf1322;
        }
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #343a40;
            color: #ffffff;
            text-align: center;
            padding: 10px 0;
            z-index: 999;
        }
        footer a {
            color: #ffc107;
            text-decoration: none;
        }
    </style>
        @if($orders->isEmpty())
        <tr>
            <td colspan="6" class="text-center">Không có đơn hàng nào.</td>
        </tr>
        @endif
        <form method="GET" class="row mb-4">
            <div class="col-md-3">
                <label for="from_date" class="form-label">Từ ngày:</label>
                <input type="date" id="from_date" name="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>
            <div class="col-md-3">
                <label for="to_date" class="form-label">Đến ngày:</label>
                <input type="date" id="to_date" name="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-success w-100">Lọc</button>
            </div>
        </form>

    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Mã đơn hàng</th>
                <th>Mã khách Hàng</th>
                <th>Ngày đặt hàng</th>              
                <th>Thành tiền</th>
                <th>Trạng thái</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $row)
            <tr>
                <td>{{ $row->OrderID }}</td>
                <td>{{ $row->UserID }}</td>
                <td>{{ \Carbon\Carbon::parse($row->OrderDate)->format('d/m/Y') }}</td>
                <td>{{ number_format($row->TotalAmount, 0, ',', '.') }} VND</td>
                <td>
                    @php
                        $statusClass = '';
                        if ($row->StatusOrders === 'Chờ xử lý') $statusClass = 'pending';
                        elseif ($row->StatusOrders === 'Hoàn thành') $statusClass = 'completed';
                        elseif ($row->StatusOrders === 'Đã hủy') $statusClass = 'cancelled';
                    @endphp
                    <span class="badge-status {{ $statusClass }}">
                        {{ $row->StatusOrders }}
                    </span>
                </td>
                <td>
                <a href="{{ url('admin/orders/' . $row->OrderID) }}" class="btn btn-primary btn-sm">
                    Xem chi tiết
                </a>


                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Chi Tiết Đơn Hàng -->
<div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="orderDetailModalLabel">Chi tiết đơn hàng</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        <!-- Dữ liệu chi tiết sẽ được Ajax load vào đây -->
      </div>
    </div>
  </div>
</div>

<footer>
    © 2025 Jacket Shop. All rights reserved. |
    <a href="{{ url('admin/dashboard') }}">Quay lại Trang Chủ</a>
</footer>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    $('.view-details').click(function() {
        var orderId = $(this).data('order-id');
        $.ajax({
            url: '/admin/orders/' + orderId,
            method: 'GET',
            success: function(data) {
                $('#orderDetailModal .modal-body').html(data);
                $('#orderDetailModal').modal('show');
            },
            error: function() {
                alert('Không lấy được chi tiết đơn hàng!');
            }
        });
    });
});
</script>
@endpush
