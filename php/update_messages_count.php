<?php
include("connMysqli2.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 從 POST 資料中取得更新後的計數值
    $updatedCount = $_POST["updateNews_ctr"];

    // 使用新的計數值更新資料庫
    $sqlUpdate = "UPDATE `ctr` SET updateNews_ctr = $updatedCount";
    mysqli_query($db_link, $sqlUpdate);
}
?>