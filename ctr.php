<?php
session_start();
include("connMysqli.php");

// 生成新的 CSRF 令牌
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // 使用安全的隨機字節生成令牌
}
header('X-Frame-Options: DENY');
?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>孕婦流感疫苗管理平台</title>
    <link rel="stylesheet" href="ctr_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
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

    .update-message {
        display: none;
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 10px;
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
            <h2 class="mb-4">點閱次數統計</h2>
            <div class="table-responsive" id="dataContainer">
                <div class="insert-btn-container">
                    <button type="button" class="btn btn-danger insert-btn" onclick="exportToCSV()"><i
                            class="fa-solid fa-download"></i>匯出</button>
                </div>

                <form method="post" action="ctr_process.php">
                    <?php
        // 包含 CSRF 令牌的隱藏欄位
        if (isset($_SESSION['csrf_token'])) {
            echo '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';
        }
        ?>
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>APP</th>
                                <th>流感E指通</th>
                                <th>接種地圖</th>
                                <th>快樂媽咪壓力指數</th>
                                <th>問題集</th>
                                <th>接種回報</th>
                                <th>疫苗E指通</th>
                                <th>行事曆</th>

                            </tr>
                        </thead>
                        <tbody class="table-light  ">
                            <?php
                                include("connMysqli.php");

                                $sql_query = "SELECT * FROM `ctr`";
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
                                    
                                    </tr>";
                                }
                            ?>
                        </tbody>
                    </table>

            </div>
        </section>
    </main>
    <script>
    // 設置 CSRF 令牌的 JavaScript 函數
    function setCsrfToken() {
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        document.querySelector('input[name="csrf_token"]').value = csrfToken;
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

    <script>
    function exportToCSV() {
        // 取得表格數據
        var table = document.getElementById("dataContainer").getElementsByTagName('table')[0];
        var rows = table.getElementsByTagName('tr');

        // 創建CSV內容
        var csvContent = "\uFEFF"; // 加入BOM，確保UTF-8編碼

        // 新增標題
        var headerCells = rows[0].getElementsByTagName('th');
        var headerData = [];
        for (var k = 0; k < headerCells.length; k++) {
            headerData.push('"' + headerCells[k].innerText.replace(/"/g, '""') + '"');
        }
        csvContent += headerData.join(',') + "\n";

        // 新增數據
        for (var i = 1; i < rows.length; i++) {
            var cells = rows[i].getElementsByTagName('td');
            var rowData = [];
            for (var j = 0; j < cells.length; j++) {
                rowData.push('"' + cells[j].innerText.replace(/"/g, '""') + '"');
            }
            csvContent += rowData.join(',') + "\n";
        }

        // 提示使用者輸入檔名
        var fileName = prompt("請輸入檔案名稱（不需要新增副檔名）：", "ctr_data");

        if (fileName !== null) {
            // 建立BLOB
            var blob = new Blob([csvContent], {
                type: 'text/csv;charset=utf-8;'
            });
            // 建立下載連結
            var link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.setAttribute("download", fileName + ".csv");
            document.body.appendChild(link);

            // 點擊匯出按鈕開始下載
            link.click();
        }
    }
    </script>
    <script>
    < /body>

    <
    /html>