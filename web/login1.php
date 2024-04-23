<?php
include("connMysqli.php");
ini_set('display_errors', 0);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $manageraccount = $_POST["manageraccount"];
    $managerpassword = $_POST["managerpassword"];

    // 使用預備語句和參數化查詢來防止SQL注入
    $query = "SELECT * FROM `account_manager` WHERE manageraccount = ? AND managerpassword = ?";
    $stmt = mysqli_prepare($db_link, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $manageraccount, $managerpassword);
        mysqli_stmt_execute($stmt);
        $query_run = mysqli_stmt_get_result($stmt);

        if ($query_run) {
            if (mysqli_num_rows($query_run) > 0) {
                // 登入成功
                $_SESSION['loggedin'] = true;
                header("Location: userdata.php");
                exit();
            } else {
                // 帳號或密碼錯誤
                header("Location: login_default.php");
                exit();
            }
        } else {
            // 查詢失敗處理
            error_log('查詢失敗: ' . mysqli_error($db_link));
            header("Location: error_page.php");
            exit();
        }

        mysqli_stmt_close($stmt);
    } else {
        // 預備語句失敗處理
        error_log('預備語句失敗: ' . mysqli_error($db_link));
        header("Location: error_page.php");
        exit();
    }

    mysqli_close($db_link);
}
?>