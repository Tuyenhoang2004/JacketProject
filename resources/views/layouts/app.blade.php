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
    </style>
</head>
<body>

    <header>
        <div class="container clearfix">
            <div class="logo">Jacket Shop</div>
            <div class="icons">
                <a href="#"><i class="fas fa-search"></i></a>
                <a href="#"><i class="fas fa-user"></i></a>
                <a href="#"><i class="fas fa-shopping-cart"></i></a>
            </div>
        </div>
    </header>

    <div class="container mt-4">
        @yield('content')
    </div>

    <footer>
        &copy; {{ date('Y') }} Jacket Shop. All rights reserved.
    </footer>

</body>
</html>
