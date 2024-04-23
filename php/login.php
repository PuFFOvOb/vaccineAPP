<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    //引入設定資料庫的程式
    include("connMysqli.php");

    //設定參數
    $name = $_POST["name"];
    $password = $_POST["password"];

    //使用SQL的SELECT *
    $result = mysqli_query($db_link, "SELECT * FROM `user` WHERE `name` = '$name' AND `password` = '$password'");

    while($row_result=mysqli_fetch_assoc($result)){
        echo json_encode(
            $row_result
        );
    }
}
?>