<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // 引入設定資料庫的程式
    include("connMysqli_NKUST.php");

    // 設定參數
    $name = $_POST["name"];
    $readNumbers = $_POST["readNumbers"];
    $result = mysqli_query($db_link,"SELECT * FROM `news` WHERE setting = 1 
    AND `number` IN ($readNumbers) ORDER BY `number` DESC ");
    $output = array();
    while ($row_result = mysqli_fetch_assoc($result)) {
        $output[] = $row_result;
    }
    echo json_encode($output);
}
?>
