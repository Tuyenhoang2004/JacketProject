@if(session('success'))
    <div class="alert alert-success" style="
        background-color: #d4edda;
        color: #155724;
        padding: 15px;
        margin: 20px auto;
        width: 80%;
        border: 1px solid #c3e6cb;
        border-radius: 5px;
        text-align: center;
        font-weight: bold;
    ">
        {{ session('success') }}
    </div>
@endif
