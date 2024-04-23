<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    //引入設定資料庫的程式
    include("connMysqli.php");

    //設定參數
    $name = $_POST["name"];

    //使用SQL的SELECT *
    $result = mysqli_query($db_link, "UPDATE `user` SET `online`='0' WHERE  `name` = '$name'");
}
?>