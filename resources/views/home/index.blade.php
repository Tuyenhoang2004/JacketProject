<!DOCTYPE html>
<html lang="vi">
@include('layouts.menu')

<head>
    <meta charset="UTF-8">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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

        .alert-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 20px 30px;
            border-radius: 10px;
            text-align: center;
            font-weight: bold;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }

        .alert-success button {
            margin-top: 15px;
            padding: 8px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .alert-success button:hover {
            background-color: #218838;
        }

        .checkout-form {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-top: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .checkout-form input,
        .checkout-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .checkout-form button {
            background-color: #FFBA28;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .checkout-form button:hover {
            background-color: #e0a800;
        }
    </style>
</head>
<body>

@if(session('success'))
    <div class="alert-overlay" id="alertBox">
        <div class="alert-success">
            {{ session('success') }}<br>
            <button onclick="closeAlert()">OK</button>
        </div>
    </div>
@endif
<script>
    function closeAlert() {
        document.getElementById('alertBox').style.display = 'none';
    }
</script>

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


<script>
    function closeAlert() {
        const alertBox = document.getElementById('alertBox');
        if (alertBox) {
            alertBox.style.display = 'none';
        }
    }
</script>
</body>
</html>
