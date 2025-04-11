<!DOCTYPE html>
<html lang="vi">
@include('layouts.menu')

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <meta charset="UTF-8">
    <title>Trang chủ</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            grid-gap: 20px;
        }

        .item img {
            width: 200px;
            height: 200px;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .item img:hover {
            transform: scale(1.05);
        }

        .item {
            text-align: center;
            overflow: hidden;
            border-radius: 10px;
            border: 1px solid #ddd;
            background-color: #fff;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .item a {
            text-decoration: none;
            color: #333;
        }

        .item a:hover {
            color: black;
        }

        .item .btn {
            display: inline-block;
            background-color: #FFD73B;
            color: black;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
            margin-bottom: 5px;
        }

        .item .btn:hover {
            background-color: #0056b3;
            color: white;
        }

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


        .pagination {
            margin: 20px 0;
            text-align: center;
        }

        .pagination a {
            margin: 0 5px;
            text-decoration: none;
            color: #007bff;
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: #007bff;
            color: #fff;
        }

        .pagination a[style*="font-weight: bold;"] {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>


@if($products->isEmpty())
    <p>Không tìm thấy sản phẩm nào phù hợp với từ khóa "<strong>{{ request('search') }}</strong>".</p>
@endif

    <!-- DANH SÁCH SẢN PHẨM -->
    <div class="grid-container">
        @foreach ($products as $row)
            <div class="item">
                <a href="{{ url('product/'.$row->ProductID) }}">
                    <img src="{{ asset('image/' . $row->ImageURL) }}" alt="{{ $row->ProductName }}">
                    <b>
                        {{ strlen($row->ProductName) > 30 ? substr($row->ProductName, 0, 30).'...' : $row->ProductName }}
                    </b><br>
                    <i>{{ number_format($row->Price, 0, ',', '.') }} VNĐ</i><br>
                    <button class="btn">Xem chi tiết</button>
                </a>
            </div>
        @endforeach
    </div>

    <!-- PHÂN TRANG -->
    <div class="pagination">
        @if ($page > 1)
            <a href="?page={{ $page - 1 }}{{ $catalogID ? '&catalog='.$catalogID : '' }}">Trang trước</a>
        @endif

        @for ($i = 1; $i <= $total_pages; $i++)
            <a href="?page={{ $i }}{{ $catalogID ? '&catalog='.$catalogID : '' }}"
               style="font-weight: {{ $i == $page ? 'bold' : 'normal' }};">{{ $i }}</a>
        @endfor

        @if ($page < $total_pages)
            <a href="?page={{ $page + 1 }}{{ $catalogID ? '&catalog='.$catalogID : '' }}">Trang tiếp</a>
        @endif
    </div>

</body>
</html>
