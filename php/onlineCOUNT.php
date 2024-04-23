<?php
if ($_SERVER['REQUEST_METHOD'] == "GET") {
     //引入設定資料庫的程式
    include("connMysqli.php");

    //使用SQL的UPDATE
    $result = mysqli_query($db_link,"SELECT COUNT(*) FROM user WHERE `online` = 1");
    
    while($row_result=mysqli_fetch_assoc($result)){
        echo json_encode(
            $row_result
        );
    }
}
?>