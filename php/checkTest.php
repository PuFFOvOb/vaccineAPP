<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // 引入設定資料庫的程式
    include("connMysqli.php");

    // 設定參數
    $name = $_POST["name"];
    $number = $_POST["number"];

    $checkQuery = mysqli_query($db_link, "SELECT `$number` FROM `user` WHERE `name`= '$name'");
    
    if ($row_result = mysqli_fetch_assoc($checkQuery)) {
        echo json_encode($row_result);
    } else {
        echo json_encode(array('error' => 'User not found'));
    }
}
?>