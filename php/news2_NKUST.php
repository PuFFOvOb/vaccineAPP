<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // 引入設定資料庫的程式
    include("connMysqli_NKUST.php");

    // 設定參數
    $name = $_POST["name"];
    $limit = $_POST["limit"];
    $readNumbers = $_POST["readNumbers"];
    //抓取以讀取過且時間最新的消息
    $result = mysqli_query($db_link,"SELECT * FROM `news` WHERE setting = 1 
    AND `number` IN ($readNumbers) ORDER BY `number` DESC LIMIT $limit");
    //將全部消息放入陣列中
    $output = array();
    while ($row_result = mysqli_fetch_assoc($result)) {
        $output[] = $row_result;
    }
    //轉換成 JSON 格式
    echo json_encode($output);
}
?>