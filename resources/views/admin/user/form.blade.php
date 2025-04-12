@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>{{ isset($user) ? 'Sửa người dùng' : 'Thêm người dùng' }}</h2>

    <form method="POST" action="{{ isset($user) ? route('users.update', $user->UserID) : route('users.store') }}">
        @csrf
        @if(isset($user))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="UserName" class="form-label">Tên người dùng</label>
            <input type="text" class="form-control" name="UserName" value="{{ old('UserName', $user->UserName ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="UserEmail" class="form-label">Email</label>
            <input type="email" class="form-control" name="UserEmail" value="{{ old('UserEmail', $user->UserEmail ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="UserPhone" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" name="UserPhone" value="{{ old('UserPhone', $user->UserPhone ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="UserAddress" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control" name="UserAddress" value="{{ old('UserAddress', $user->UserAddress ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Vai trò</label>
            <select class="form-select" name="role">
                <option value="user" {{ (old('role', $user->role ?? '') == 'user') ? 'selected' : '' }}>User</option>
                <option value="admin" {{ (old('role', $user->role ?? '') == 'admin') ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        @if (!isset($user))
        <div class="mb-3">
            <label for="UserPassword" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" name="UserPassword" required>
        </div>
        @endif

        <button type="submit" class="btn btn-primary">
            {{ isset($user) ? 'Cập nhật' : 'Thêm mới' }}
        </button>
    </form>
</div>
@endsection
