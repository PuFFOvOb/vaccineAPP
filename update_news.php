<?php
include("connMysqli.php");
header('X-Frame-Options: DENY');
?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>更新資料介面</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="update_news_style.css">
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
        <h1 class="text-center">更新消息</h1>

        <?php
        include("connMysqli2.php");

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $sql_query = "SELECT * FROM `news` WHERE number  = $id";
            $result = mysqli_query($db_link, $sql_query);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
        ?>
        <form method="post" action="update_news_data.php">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="mb-3">
                <label for="label" class="form-label">標籤：</label>
                <select name="label" id="label" class="form-select">
                    <!-- 從資料庫檢索並顯示唯一的標籤 -->
                    <?php
                    $label_query = "SELECT DISTINCT `label` FROM `label_item`";
                    $label_result = mysqli_query($db_link, $label_query);

                    while ($label_row = mysqli_fetch_array($label_result)) {
                    $selected = ($label_row[0] == $row[1]) ? "selected" : "";
                     echo "<option value='$label_row[0]' $selected>$label_row[0]</option>";
            }
             ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">日期：</label>
                <input type="date" name="date" id="date" class="form-control" value="<?php echo $row['date']; ?>">
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">標題：</label>
                <input type="text" name="title" id="title" class="form-control" value="<?php echo $row['title']; ?>">
            </div>
            <div class="mb-3">
                <label for="url" class="form-label">連結：</label>
                <input type="text" name="url" id="url" class="form-control" value="<?php echo $row['url']; ?>">
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


</html>