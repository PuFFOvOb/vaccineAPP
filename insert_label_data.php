<?php
include("connMysqli2.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["label"])) {
    $label = $_POST["label"];

    // 防止 SQL 注入
    $label = mysqli_real_escape_string($db_link, $label);

    // 安全性檢查，例如檢查標籤是否符合預期的格式、長度等

    // SQL 新增資料語法
    $sql = "INSERT INTO `label_item`(`label`) VALUES ('$label')";

    if (mysqli_query($db_link, $sql)) {
        // 新增成功
        header("Location: news.php"); // 跳回資料庫介面
        exit(); // 確保在跳轉之前終止腳本執行
    } else {
        // 新增失敗，提供錯誤訊息
        echo "資料新增失敗：" . mysqli_error($db_link) . "<br>";
    }
}

// 關閉資料庫連接
mysqli_close($db_link);
?>