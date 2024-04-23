<?php
session_start();
include("connMysqli.php");
header('X-Frame-Options: DENY');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 檢查 CSRF 令牌是否存在
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        // CSRF 令牌無效，執行適當的處理，例如拒絕請求或重新導向到錯誤頁面
        die("CSRF Attack Detected!");
    }

    // CSRF 令牌驗證通過，繼續處理表單數據
    // 處理表單數據的程式碼...

    // 清除 CSRF 令牌，防止重複使用
    unset($_SESSION['csrf_token']);
}
?>