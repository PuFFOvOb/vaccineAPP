<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // 引入設定資料庫的程式
    include("connMysqli.php");

    // 設定參數
    $name = $_POST["name"];
    $password = $_POST["password"];
    
    // 創建資料表
    $result = mysqli_query($db_link, "CREATE TABLE `$name`(`news_number` INT PRIMARY KEY);");
     
    // 關閉資料庫連線
    mysqli_close($db_link);
}
?>