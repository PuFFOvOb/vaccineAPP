<?php
include("connMysqli.php");
header('X-Frame-Options: SAMEORIGIN');

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

    .insert-btn-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 10px;
    }

    .insert-btn {
        width: 700px;
        height: 40px;
        color: #fff;
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
                            <div class="container">
                                <h1 class="text-center">管理人員帳號或密碼錯誤</h1>
                                <div class="insert-btn-container">
                                    <button type="button" class="btn btn-primary insert-btn "
                                        onclick="window.location.href='login_page.php'">確認</button>
                                </div>
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