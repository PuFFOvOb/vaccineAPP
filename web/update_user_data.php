<?php
include("connMysqli.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["new_username"])) {
    // 防範 SQL 注入
    $newUsername = mysqli_real_escape_string($db_link, $_POST["new_username"]);
    $userId = (int)$_POST["id"];

    // 資料驗證
    if ($userId <= 0) {
        echo "無效的用戶編號。";
        exit(); // 確保在此中斷腳本執行
    }

    // SQL 更新資料語法
    $sql = "UPDATE user SET name='$newUsername' WHERE userId='$userId'";

    if (mysqli_query($db_link, $sql)) {
        // 更新成功
        echo "用戶編號 $userId 更新成功。<br>";
        header("Location: userdata.php"); // 成功更新後跳回首頁
        exit(); // 確保code到這中斷
    } else {
        // 更新失敗，提供錯誤訊息
        echo "用戶編號 $userId 更新失敗：" . mysqli_error($db_link) . "<br>";
    }
}

mysqli_close($db_link);
?>