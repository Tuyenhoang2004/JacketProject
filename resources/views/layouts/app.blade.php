<!DOCTYPE html>
<<<<<<< HEAD
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
=======
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
>>>>>>> 75cae8e632b89ebb3349c0380398ac838d0e2b3a

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script src="{{ asset('js/app.js') }}" defer></script>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

<<<<<<< HEAD
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
=======
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
>>>>>>> 75cae8e632b89ebb3349c0380398ac838d0e2b3a
</html>
