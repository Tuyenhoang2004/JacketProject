<!-- resources/views/layouts/menu.blade.php -->
@php
    $catalogID = $catalogID ?? null;
@endphp

<div class="menu">
    <style>
        .menu {
            background-color: #000;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
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

        .menu li a:hover {
            background-color: #FFBA28;
            color: black;
        }

        .menu li a.active {
            background-color: #FFBA28;
            color: black;
        }

        .user-menu {
            position: relative;
        }

        .user-menu .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
            list-style: none;
            min-width: 150px;
            z-index: 999;
        }

        .user-menu:hover .dropdown-menu {
            display: block;
        }

        .user-menu .dropdown-menu li {
            padding: 1px 8px;
        }

        .user-menu .dropdown-menu li a {
            text-decoration: none;
            color: black;
            display: block;
            font-size: 13px;
        }

        .user-menu .dropdown-menu li a:hover {
            background-color: #f0f0f0;
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
            background-color: #FFBA28;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }

        .search-container button:hover {
            background-color: #e0a800;
        }
    </style>

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
            <a href="#" class="fa fa-user"></a>
            <ul class="dropdown-menu">
                @if (session('UserPhone'))
                    <li>Xin chào {{ session('UserName') }}!</li>
                    <li><a href="{{ route('logout') }}">Đăng xuất</a></li>
                @else
                    <li><a href="{{ route('signin') }}">Đăng nhập</a></li>
                    <li><a href="{{ route('signup') }}">Đăng ký</a></li>
                @endif
            </ul>
        </li>

        <li>
            <a href="{{ route('cart') }}" class="fa fa-shopping-bag"></a>
        </li>
    </ul>
</div>
