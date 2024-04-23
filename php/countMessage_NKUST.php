<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // 引入設定資料庫的程式
    include("connMysqli_NKUST.php");
    // 設定參數
    $name = $_POST["name"];
    $date = $_POST["date"];
    $readNumbers = $_POST["readNumbers"];
    //計算未讀取且允許發布的消息數量
    // $result = mysqli_query($db_link, " SELECT COUNT(*) as result FROM `news` 
    // WHERE setting = 1 AND `number` 
    // NOT IN (SELECT* FROM `$name` WHERE 1)
    // AND `date` > DATE_SUB('$date', INTERVAL 7 DAY);");
    $result = mysqli_query($db_link, "SELECT COUNT(*) as result FROM `news` 
    WHERE setting = 1 AND `number` 
    NOT IN ($readNumbers)
    AND `date` > DATE_SUB('$date', INTERVAL 7 DAY);");
    //轉換成 JSON 格式
    if ($result) {
        $row_result = mysqli_fetch_assoc($result);
        echo json_encode($row_result);
    }
}
?>
