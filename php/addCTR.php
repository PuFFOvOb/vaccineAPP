<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
     //引入設定資料庫的程式
    include("connMysqli.php");
    $name = $_POST["name"];
    $result = mysqli_query($db_link,"UPDATE ctr SET `$name` = `$name` + 1");
}
?>