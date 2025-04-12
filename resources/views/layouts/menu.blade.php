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
            padding: 5px 0;
            border-radius: 8px;
            min-width: 180px;
        }

        .user-menu .dropdown-menu li {
            padding: 8px 15px;
            font-size: 14px;
        }

        .user-menu .dropdown-menu li a {
            color: #333;
            transition: background-color 0.2s;
        }

        .user-menu .dropdown-menu li a:hover,
        .user-menu .dropdown-menu .logout-btn:hover {
            background-color: #f7f7f7;
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
            color: #c9302c;
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

        <li>
            <a href="{{ route('cart') }}" class="fa fa-shopping-bag"></a>
        </li>
    </ul>
</div>
