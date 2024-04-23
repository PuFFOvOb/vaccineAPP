<?php
session_start();

// 生成新的 CSRF 令牌
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // 使用安全的隨機字節生成令牌
}
include("connMysqli2.php");
header('X-Frame-Options: DENY');
?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>孕婦流感疫苗管理平台</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="news_style.css">
    <style>
    body {
        /*畫面設置 */

        background-image: url('封面.png');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        font-family: Arial, sans-serif;
    }

    /* 自定義表格樣式 */
    .custom-table {

        border-collapse: collapse;
        width: 100%;
        overflow: auto;
        height: 100px;
    }

    .custom-table th,
    .custom-table td {
        padding: 6px;
        text-align: center;
    }

    .update-btn-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 10px;
    }

    .update-btn {


        width: 100px;
        height: 40px;
        color: #fff;
    }
    </style>
</head>

<body>
    <header class="bg-danger text-white p-4 bg-opacity-10">
        <h1 class="text-center fw-bolder  ">歡迎來到孕婦流感疫苗管理平台</h1>
        <nav class="navbar navbar-expand-lg">
            <ul class="navbar-nav ml-auto">

                <li class="nav-item">
                    <a class="nav-link fs-6 fw-bolder" href="userdata.php">帳號管理</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-6 fw-bolder" href="news.php">消息分類</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-6 fw-bolder" href="ctr.php">點閱次數</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-6 fw-bolder" href="login_page.php">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"
                            style="transform: rotate(90deg);">
                            <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path
                                d="M246.6 9.4c-12.5-12.5-32.8-12.5-45.3 0l-128 128c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 109.3V320c0 17.7 14.3 32 32 32s32-14.3 32-32V109.3l73.4 73.4c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-128-128zM64 352c0-17.7-14.3-32-32-32s-32 14.3-32 32v64c0 53 43 96 96 96H352c53 0 96-43 96-96V352c0-17.7-14.3-32-32-32s-32 14.3-32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V352z" />
                        </svg>
                        </svg>
                        <span class="text-lg">登出</span>
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <main class="container mt-4">
        <section class="user-management">
            <h2 class="mb-4">消息管理</h2>
            <div class="table-responsive" id="dataContainer">
                <form method="post" action="update_news.php">
                    <?php
                                // 檢查 $_SESSION['csrf_token'] 是否已經被定義
                                if (isset($_SESSION['csrf_token'])) {
                                    echo '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';
                                }
                                ?>
                    <table class="table table-bordered table-striped custom-table">

                        <thead class="table-danger  text-center  ">
                            <tr>
                                <th>編號</th>
                                <th>標籤</th>
                                <th>日期</th>
                                <th>標題</th>
                                <th>連結</th>
                                <th>類型</th>
                                <th>點閱次數</th>
                                <th>是否發布</th>
                                <th></th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody class="table-light  ">
                            <?php
                                include("connMysqli2.php");

                                $sql_query = "SELECT * FROM `news`";
                                $result = mysqli_query($db_link, $sql_query);

                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<tr>
                                    <td>$row[0]</td> 
                                    <td>$row[1]</td>
                                    <td>$row[2]</td>
                                    <td>$row[3]</td>
                                    <td>$row[4]</td>
                                    <td>$row[5]</td>
                                    <td>$row[6]</td>
                                    <td>$row[7]</td>
                                    <td> <input type='checkbox' name='checkbox[]' value='$row[0]'></td>
                                    <td></td>
                                    </tr>";
                                }
                            ?>
                        </tbody>
                    </table>

                </form>

            </div>
        </section>

    </main>
    <script>
    function loadData() {
        // 創一個新的XMLHttpRequest
        var xhr = new XMLHttpRequest();

        // ajax配置請求
        xhr.open("GET", "reloadnews.php", true);

        //設定request後回調函數
        xhr.onload = function() {
            if (xhr.status === 200) {
                // 請求成功，重新顯示container內容
                document.getElementById("dataContainer").innerHTML = xhr.responseText;
            }
        };

        // ajax配置請求
        xhr.send();
    }

    // 重新加載頁面
    loadData();

    // 固定時間加載頁面
    setInterval(loadData, 300000); // 五分鐘
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>

</html>