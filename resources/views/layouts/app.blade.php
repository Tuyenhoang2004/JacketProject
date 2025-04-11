<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container mt-4">
        @yield('content')
    </div>

    <footer style="
        position: fixed;
        bottom: 0;
        width: 100%;
        background-color: #343a40;
        color: #ffffff;
        text-align: center;
        padding: 10px 0;
        z-index: 999;
    ">
        © 2025 Admin Panel. All rights reserved. |
        <a href="{{ url('admin/dashboard') }}" style="color: #ffc107; text-decoration: none;">
            Quay lại Trang Chủ
        </a>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            margin: 0;
            padding-bottom: 100px;
            overflow-y: auto;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 50px;
            background-color: #333;
            color: white;
            text-align: center;
            line-height: 50px;
        }
    </style>
</body>
</html>
