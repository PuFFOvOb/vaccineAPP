<?php
session_start();
// 生成新的 CSRF 令牌
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // 使用安全的隨機字節生成令牌
}
include("connMysqli.php");
header('X-Frame-Options: DENY');
?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>孕婦流感疫苗管理平台</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="userdata_style.css">
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
        background-color: #f5f5f5;
        border-collapse: collapse;
        width: 100%;
        overflow: auto;
        height: 100px;
    }

    .custom-table th,
    .custom-table td {
        padding: 10px;
        text-align: center;

    }

    .custom-table th {
        background-color: #333;
        color: #fff;
    }

    .custom-table tr:nth-child(even) {
        background-color: #ddd;
    }

    .custom-table tr:hover {
        background-color: #aaa;
    }

    .insert-btn-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 10px;
    }

    .insert-btn {
        width: 100px;
        height: 40px;
        color: #fff;
    }

    .output-btn {
        width: 100px;
        height: 40px;
        color: #fff;
    }
    </style>
</head>

<body>
    <header class="bg-danger text-white p-4 bg-opacity-10">
        <h1 class="text-center fw-bolder">歡迎來到孕婦流感疫苗管理平台</h1>
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
            <h2 class="mb-4">帳號管理</h2>
            <div class="table-responsive" id="dataContainer">
                <form method="post" action="update_data.php">
                    <?php
                                // 檢查 $_SESSION['csrf_token'] 是否已經被定義
                                if (isset($_SESSION['csrf_token'])) {
                                    echo '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';
                                }
                                ?>
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <table class="custom-table">
                        <thead>
                            <tr>

                                <th>用戶名稱</th>

                                <th>用戶上線</th>
                                <th>用戶註冊日期</th>
                                <th>第一次測試</th>
                                <th>第二次測試</th>
                                <th>第三次測試</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
    /*session_start(); 
    header('Content-Type: text/html; charset=utf8');*/
    
    include("connMysqli.php");

    // 檢查管理人員帳號密碼是否正確
    if (isset($_POST["manageraccount"]) && isset($_POST["managerpassword"])) {
        $manageraccount = $_POST["manageraccount"];
        $managerpassword = $_POST["managerpassword"];

        // 檢查管理人員帳號密碼是否正確匹配資料庫內容
        $sql_query_login = "SELECT * FROM `account_manager` WHERE manageraccount='$manageraccount' AND managerpassword='$managerpassword'";

        // 查詢失敗停止
        $result1 = mysqli_query($db_link, $sql_query_login) or die("查詢失敗");

        // 如果匹配便顯示資料庫資料
        if (mysqli_num_rows($result1)) {
            // 查詢新消息的數量
            
            // 查詢用戶帳號
            $sql_query = "SELECT * FROM `user`";
            $result = mysqli_query($db_link, $sql_query);

            
            echo "<table border='1'>
                    <tr>
                        <th>用戶編號</th>
                        <th>用戶名稱</th>
                        <th>用戶密碼</th>
                        <th>上線</th>
                         <th>日期</th>
                        <th class='actions-column'>操作</th>
                    </tr>";

            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>
                        <td>$row[0]</td> 
                        <td>$row[1]</td>
                        <td>$row[2]</td>
                        <td>$row[3]</td>
                        <td>$row[4]</td>
                        <td><a href='update_data.php?id=$row[0]' class='btn btn-danger edit-btn   '>修改</a></td>
                        <td><a href='delete_userdata.php?id=$row[0]' class='btn btn-danger delete-btn  '>刪除</a></td>
                      </tr>";
            }

            echo "</table>";
        } else {
            // 登入失敗的消息
            echo "登入失敗";
        }
    }
?>

                        </tbody>
                    </table>
                    <div class="update-btn-container">
                        <button type="button" class="btn btn-warning insert-btn "
                            onclick="window.location.href='insert_data.php'"><i
                                class='fa-solid fa-user-plus'>新增資料</i></button>
                    </div>
            </div>

        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>


    <script>
    function loadData() {
        // 創一個新的XMLHttpRequest
        var xhr = new XMLHttpRequest();

        // ajax配置請求
        xhr.open("GET", "reloaduserdata.php", true);

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
    setInterval(loadData, 5000); // 5秒
    </script>
    <script>
    <?php
    include("connMysqli2.php");

    $updateMessagesCount = 0;
    $sqlQueryUpdateMessages = "SELECT updateNews_ctr FROM `ctr`";
    $resultUpdateMessages = mysqli_query($db_link, $sqlQueryUpdateMessages);

    if ($rowUpdateMessages = mysqli_fetch_array($resultUpdateMessages)) {
        $updateMessagesCount = $rowUpdateMessages['updateNews_ctr'];
    }
    ?>

    var updateMessagesCount = <?php echo $updateMessagesCount; ?>;

    window.onload = function() {
        if (updateMessagesCount > 0) {
            var confirmation = confirm("有更新" + updateMessagesCount + " 條新消息數。");

            if (confirmation) {
                // 使用者點選確定按鈕，執行歸零操作
                resetUpdateMessagesCount();
            }
        }
    };

    function resetUpdateMessagesCount() {
        fetch('update_messages_count.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'updateNews_ctr=0',
        })

    }
    </script>
    <script>
    function exportToCSV() {
        var table = document.getElementById("dataContainer").getElementsByTagName('table')[0];
        var rows = table.getElementsByTagName('tr');
        var csvContent = "\uFEFF";

        var headerCells = rows[0].getElementsByTagName('th');
        var headerData = [];
        for (var k = 0; k < headerCells.length; k++) {
            headerData.push('"' + headerCells[k].innerText.replace(/"/g, '""') + '"');
        }
        csvContent += headerData.join(',') + "\n";

        for (var i = 1; i < rows.length; i++) {
            var cells = rows[i].getElementsByTagName('td');
            var rowData = [];

            for (var j = 0; j < cells.length; j++) {
                // 將單元格內的 "刪除" 和 "修改" 字詞替換為空字符串
                var cellText = cells[j].innerText.replace(/刪除|修改/g, '').trim();
                rowData.push('"' + cellText.replace(/"/g, '""') + '"');
            }

            csvContent += rowData.join(',') + "\n";
        }

        var fileName = prompt("請輸入檔案名稱（不需要新增副檔名）：", "ctr_data");

        if (fileName !== null) {
            var blob = new Blob([csvContent], {
                type: 'text/csv;charset=utf-8;'
            });
            var link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.setAttribute("download", fileName + ".csv");
            document.body.appendChild(link);
            link.click();
        }
    }
    </script>
</body>

</html>