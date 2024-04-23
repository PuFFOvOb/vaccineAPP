<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // 引入設定資料庫的程式
    include("connMysqli.php");

    // 設定參數
    $name = $_POST["name"];
    $password = $_POST["password"];

    // 使用SQL的SELECT語句檢查是否已存在該name值
    $checkQuery = mysqli_query($db_link, "SELECT * FROM `user` WHERE `name` = '$name'");
    
    if (mysqli_num_rows($checkQuery) > 0) {
        // 名稱已存在，輸出錯誤訊息
        echo "Name already exists.";
    } else {
        // 名稱不存在，進行插入操作
        $result = mysqli_query($db_link, "INSERT INTO `user`(`name`, `password`, `date`) VALUES ('$name','$password', CURDATE())");
    }
}
?>
