<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // 引入設定資料庫的程式
    include("connMysqli_NKUST.php");
    // 設定參數
    $name = $_POST["name"];
    $readNumbers = $_POST["readNumbers"];
    //抓取允許發布且未看過的最新五則消息
    $result = mysqli_query($db_link,"SELECT * FROM `news` WHERE setting = 1 
    AND `number` NOT IN ($readNumbers) ORDER BY `number` DESC LIMIT 5");
    //將全部消息放入陣列中
    $output = array();
    while ($row_result = mysqli_fetch_assoc($result)) {
        $output[] = $row_result;
    }
    //轉換成 JSON 格式
    echo json_encode($output);
}
?>