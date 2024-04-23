<?php
include("connMysqli2.php");



if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];
    
    // sql刪除語法
    $sql = "DELETE FROM `news` WHERE number = $id";
    
    if (mysqli_query($db_link, $sql)) {
        // 刪除成功，跳回原始介面
        header("Location: news.php");
    } else {
        // 刪除失敗
        echo "刪除失敗：" . mysqli_error($db_link);
    }

}

// 關閉資料庫連接
mysqli_close($db_link);
?>