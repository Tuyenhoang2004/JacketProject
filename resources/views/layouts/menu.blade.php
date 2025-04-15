<!-- resources/views/layouts/menu.blade.php -->
@php
    $catalogID = $catalogID ?? null;
@endphp
<style>
        .menu {
            background-color: #000;
            padding: 10px 20px;
            border-radius: 5px;
            margin-bottom: 10px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }


        .menu ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
        }

        .menu li {
            margin: 0 10px;
        }

        .menu li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .user-menu:hover .dropdown-menu li a {
            color: black;
        }

        .menu li a:hover {
            background-color: rgb(252, 5, 141);
            color: black;
        }

        .menu li a.active {
            background-color: rgb(252, 5, 141);
            color: black;
        }

        .user-menu {
        position: relative;
        display: inline-block;
        }

        .user-menu .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            color: white;
            min-width: 160px;
            padding: 10px 0;
            border-radius: 5px;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .user-menu:hover .dropdown-menu {
            display: block;
        }

        .logout-btn {
            background: none;
            border: 3px;
            color: red;
            padding: 8px 15px;
            text-align: left;
            width: 100%;
            cursor: pointer;
        }

        .dropdown-menu li {
            padding: 8px 15px;
            color: black;
            font-weight: bold;
        }

        .dropdown-menu li a {
            color: white;
            text-decoration: none;
            display: block;
        }

        .dropdown-menu li a:hover {
            background-color: #333;
        }

        .logout-btn {
            background: none;
            border: none;
            color: #d9534f;
            cursor: pointer;
            font-size: 14px;
            text-align: left;
            width: 100%;
            padding: 0;
        }

        .logout-btn:hover {
            color:rgb(120, 9, 5);
        }


        .search-box {
            display: flex;
            align-items: center;
        }

        .search-container input[type="text"] {
            padding: 5px;
            border-radius: 5px 0 0 5px;
            border: none;
        }

        .search-container button {
            padding: 5px 10px;
            border: none;
            background-color: rgb(252, 5, 141);
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }

        .search-container button:hover {
            background-color: rgb(252, 5, 141);
        }
        .cart-menu {
            position: relative;
            display: inline-block;
        }

        .cart-menu .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            color: white;
            min-width: 160px;
            padding: 10px 0;
            border-radius: 5px;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .cart-menu:hover .dropdown-menu {
            display: block;
        }

        .cart-menu .dropdown-menu li {
            padding: 8px 15px;
            color: black;
            font-weight: bold;
        }

        .cart-menu .dropdown-menu li a {
            color: #333;
            text-decoration: none;
            display: block;
            font-weight: normal;
        }

        .cart-menu .dropdown-menu li a:hover {
            background-color: #f8f8f8;
            color: rgb(252, 5, 141);;
        }
        .custom-btn {
            background-color: white; /* Màu nền trắng */
            color: black; 
        }

        .custom-btn:hover {
            background-color: #f0f0f0; /* Màu nền khi hover */
            color: #333; /* Màu chữ khi hover */
        }
        
    </style>
<div class="menu">

    <ul>
        <li>
            <a href="{{ route('home') }}" class="{{ empty($catalogID) ? 'active' : '' }}">Trang chủ</a>
        </li>

        @foreach ($list_catalog as $row)
            <li>
                <a href="{{ route('home', ['catalog' => $row->CatalogID]) }}"
                   class="{{ $catalogID == $row->CatalogID ? 'active' : '' }}">
                    {{ $row->CatalogName }}
                </a>
            </li>
        @endforeach

        <li>
            <form method="GET" action="{{ route('search') }}" class="search-box">
                <div class="search-container">
                    <input type="text" name="search" placeholder="Tìm kiếm sản phẩm" value="{{ request('search') }}">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </li>

        <li class="user-menu">
            <a href="#" class="fa fa-user" onclick="return false;"></a>
            <ul class="dropdown-menu">
                @if(Auth::check())
                    <li style="padding: 8px 15px; font-weight: bold;">
                        Hello, {{ Auth::user()->UserName }}
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="logout-btn">Đăng xuất</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">Đăng nhập</a></li>
                    <li><a href="{{ route('register') }}">Đăng ký</a></li>
                @endif
            </ul>

        </li>

        <li class="cart-menu">
            <a href="#" class="fa fa-shopping-bag" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="{{ route('cart') }}">Giỏ hàng</a>
                </li>
                <li>
                  <a href="{{ route('checkout.history') }}" class="custom-btn" style="margin-top: 20px;">Lịch sử mua hàng</a>
                </li>
            </ul>
        </li>

    </ul>
</div>
