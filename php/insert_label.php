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
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }

    .insert-btn {
        /* 新增按鈕*/
        background-color: #007bff;
        color: #fff;
        position: relative;
        left: 1245px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">新增標籤</h1>
        <form method="post" action="insert_label_data.php">

            <div class='mb-3'>
                <label for='username' class='form-label'>標籤名稱：</label>
                <input type='text' name='label' id='lable' class='form-control' required>

            </div>

            <button type="submit" class="btn btn-primary insert-btn">新增</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>

</html>