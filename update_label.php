<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>更新資料介面</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
    body {
        display: flex;
        justify-content: center;
        /* 更新的container放置在畫面正中央*/
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

    .update-btn {
        /* 更新按鈕*/
        background-color: #007bff;
        color: #fff;
        position: relative;
        left: 1200px;
    }
    </style>
</head>


<body>
    <div class="container">
        <h1 class="text-center">更新標籤資料</h1>

        <?php
        include("connMysqli2.php");

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql_query = "SELECT * FROM `label_item` WHERE number  = $id";
            $result = mysqli_query($db_link, $sql_query);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
        ?>
        <form method="post" action="update_label_data.php">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="mb-3">
                <label for="label" class="form-label">標籤名稱：</label>
                <input type="text" name="label" id="label" class="form-control" value="<?php echo $row['label']; ?>">

            </div>

            <button type="submit" class="btn btn-primary update-btn">確認更新</button>
        </form>
        <?php
            } else {
                echo "未找到ID參數。";
            }
        } else {
            echo "未提供ID參數。";
        }
        mysqli_close($db_link);
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>

</html>