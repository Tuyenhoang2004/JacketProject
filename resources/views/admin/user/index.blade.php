@extends('layouts.admin')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mt-4">
        <h2>Quản lý người dùng</h2>

        <form method="GET" action="{{ route('user.index') }}" class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="name" class="form-control" placeholder="Tìm theo tên" value="{{ request('name') }}">
            </div>
            <div class="col-md-4">
                <input type="text" name="email" class="form-control" placeholder="Tìm theo email" value="{{ request('email') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </div>
        </form>

        <a href="{{ route('users.create') }}" class="btn btn-success mb-3">➕ Thêm người dùng</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>SĐT</th>
                    <th>Địa chỉ</th>
                    <th>Vai trò</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->UserID }}</td>
                    <td>{{ $user->UserName }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->UserPhone }}</td>
                    <td>{{ $user->UserAddress }}</td>
                    <td>{{ $user->role ?? 'user' }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->UserID) }}" class="btn btn-warning btn-sm">Sửa</a>
                        <form action="{{ route('users.destroy', $user->UserID) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa User này không?')">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $users->links() }}


    </div>
@endsection
