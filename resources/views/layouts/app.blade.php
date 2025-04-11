<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jacket Shop</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #222;
            color: #fff;
            padding: 10px 0;
        }

        .container {
            width: 90%;
            margin: 0 auto;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
        }

        footer {
            background-color: #222;
            color: #fff;
            padding: 20px;
            text-align: center;
            margin-top: 40px;
        }

        .search-bar {
            float: right;
        }

        .search-bar input {
            padding: 5px;
        }

        .icons {
            float: right;
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .logo {
            font-weight: bold;
            font-size: 24px;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

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
</head>
<body>
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
        © {{ date('Y') }} Jacket Shop. All rights reserved. |
        <a href="{{ url('admin/dashboard') }}" style="color: #ffc107; text-decoration: none;">
            Quay lại Trang Chủ
        </a>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
