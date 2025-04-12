<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản lý Sản phẩm')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-4">
        @yield('content')
    </div>

    <footer style="position: fixed; bottom: 0; width: 100%; background-color: #343a40; color: #ffffff; text-align: center; padding: 10px 0;">
        © 2025 Admin Panel. All rights reserved. |
        <a href="{{ url('admin/dashboard') }}" style="color: #ffc107; text-decoration: none;">Quay lại Trang Chủ</a>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            margin: 0;
            padding-bottom: 100px;
        }
    </style>
</body>
</html>
