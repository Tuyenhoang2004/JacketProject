<form action="{{ route('admin.orders.updateStatus', $orders->id) }}" method="POST">
    @csrf
    @method('PUT')

    <select name="StatusOrders" required>
        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Chờ xử lý</option>
        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
    </select>

    <button type="submit">Cập nhật</button>
</form>

