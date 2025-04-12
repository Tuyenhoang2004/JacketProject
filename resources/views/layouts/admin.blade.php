<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    {{-- Bootstrap 4 và 5 (chỉ cần 1 cái, nên giữ Bootstrap 5 thôi) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    {{-- Chart.js --}}
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
</head>
<body>

    <div class="container mt-4">
        @yield('content')
    </div>

    <footer>
        © {{ date('Y') }} Admin Panel. All rights reserved. |
        <a href="{{ url('admin/dashboard') }}">Quay lại Trang Chủ</a>
    </footer>

    {{-- Bootstrap Bundle (JS) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
