<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // 引入設定資料庫的程式
    include("connMysqli.php");

    // 設定參數
    $name = $_POST["name"];
    $number = $_POST["number"];

    //將資料改為已看過
    $result = mysqli_query($db_link,"INSERT INTO `$name`(`news_number`) VALUES ('$number')");
    
    while($row_result=mysqli_fetch_assoc($result)){
        echo json_encode(
            $row_result
        );
    }
}
?>

