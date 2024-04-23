<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // 引入設定資料庫的程式
    include("connMysqli_NKUST.php");

    // 設定參數
    $number = $_POST["number"];

    //將資料改為已看過
    $result = mysqli_query($db_link,"UPDATE `news` SET `ctr`=`ctr`+1 WHERE `number`=$number;");
    
    while($row_result=mysqli_fetch_assoc($result)){
        echo json_encode(
            $row_result
        );
    }
}
?>