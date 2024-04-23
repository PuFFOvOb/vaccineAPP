<?php
session_start();

// 生成新的 CSRF 令牌
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // 使用安全的隨機字節生成令牌
}

include("connMysqli.php");
header('X-Frame-Options: DENY');

$query = "SELECT * FROM `account_manager`";
$query_run = mysqli_query($db_link, $query);

if (!$query_run) {
    die('查詢失敗: ' . mysqli_error($db_link));
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理人員登入</title>
    <link rel="stylesheet" href="login_default_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
    body {
        background-image: url('封面.png');
        background-color: rgba(255, 255, 255, 0.2);
        background-blend-mode: overlay;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
    }

    main {
        padding-top: 0;
    }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <header></header>
    <main>
        <div class="container">
            <div class="row justify-content-center align-items-center vh-100">
                <div class="col-12 w-auto">
                    <div class="card bg-white shadow" style="max-width: 650px; ">
                        <div class="card-body d-flex align-items-center flex-column">
                            <img src="logo.png" class="w-50 mb-3" alt="web logo">
                            <h1 class="text-center mb-1"><b>孕婦流感疫苗管理平台</b></h1>
                            <form method="POST" action="login1.php" class="w-100 mb-3">
                                <?php
                                // 檢查 $_SESSION['csrf_token'] 是否已經被定義
                                if (isset($_SESSION['csrf_token'])) {
                                    echo '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';
                                }
                                ?>
                                <div class="input-group mb-3">
                                    <label for="manageraccount" class="input-group-text fs-5">帳號</label>
                                    <input type="text" class="form-control form-control-lg" placeholder="請輸入帳號"
                                        id="manageraccount" name="manageraccount" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="input-group mb-3">
                                    <label for="managerpassword" class="input-group-text fs-5">密碼</label>
                                    <input type="password" class="form-control form-control-lg" placeholder="請輸入密碼"
                                        id="managerpassword" name="managerpassword" required>
                                    <div class="invalid-feedback"></div>
                                </div>

                                <button type="submit" class="btn btn-primary login-btn w-100" id="loginsend">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                                        <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path
                                            d="M498.1 5.6c10.1 7 15.4 19.1 13.5 31.2l-64 416c-1.5 9.7-7.4 18.2-16 23s-18.9 5.4-28 1.6L284 427.7l-68.5 74.1c-8.9 9.7-22.9 12.9-35.2 8.1S160 493.2 160 480V396.4c0-4 1.5-7.8 4.2-10.7L331.8 202.8c5.8-6.3 5.6-16-.4-22s-15.7-6.4-22-.7L106 360.8 17.7 316.6C7.1 311.3 .3 300.7 0 288.9s5.9-22.8 16.1-28.7l448-256c10.7-6.1 23.9-5.5 34 1.4z" />
                                    </svg>
                                    <span>登入</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer class="mt-auto"></footer>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>


</html>