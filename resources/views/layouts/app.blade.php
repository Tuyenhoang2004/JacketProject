<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <meta charset="UTF-8">
    <title>Jacket Shop</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        /* Giữ nguyên style trong thẻ <style> nếu bạn từng dùng trực tiếp trong HTML cũ */
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
    </style>
</head>
<body>
    <div class="container" style="padding: 20px 0;">
        @yield('content')
    </div>

    <footer>
        <p>&copy; {{ date('Y') }} Jacket Shop. All rights reserved.</p>
    </footer>
</body>
</html>
