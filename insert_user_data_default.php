<!DOCTYPE html>
<html>

<head>
    <title>孕婦流感疫苗管理平台</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新增資料介面</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
    body {
        display: flex;
        justify-content: center;
        /* 新增的container放置在畫面正中央*/
        align-items: center;
        height: 100vh;
        background-image: url('封面.png');
        /* 背景設置*/
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        font-family: Arial, sans-serif;
    }

    .container {
        /* container設置大小及邊框*/
        background-color: rgba(255, 255, 255, 0.8);
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }

    .insert-btn-container {
        display: flex;
        justify-content: center;
        margin-top: 50px;
    }

    .insert-btn {
        width: 170px;
        height: 40px;
        color: #fff;
    }

    main {
        padding-top: 0;
    }
    </style>
</head>

<body>
    <div class="container  ">
        <h1 class="text-center">用戶資料名稱已存在。</h1>
        <div class="insert-btn-container">
            <button type="button" class="btn btn-primary insert-btn"
                onclick="window.location.href='insert_data.php'">確認</button>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>

</html>