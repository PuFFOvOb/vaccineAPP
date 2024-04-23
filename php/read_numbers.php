<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // 引入設定資料庫的程式
    include("connMysqli.php");
    // 設定參數
    $name = $_POST["name"];
    // 使用 SQL 的 SELECT 語句檢查是否已存在該 name 值
    $checkQuery = mysqli_query($db_link, "SELECT * FROM `$name` WHERE 1");
    $output = array(); // 用來存儲所有資料的陣列
    while ($row_result = mysqli_fetch_assoc($checkQuery)) {
        $output[] = $row_result; // 將每一行資料加入到陣列中
    }
    if (!empty($output)) {
        echo json_encode($output); // 如果有資料，回傳陣列
    } else {
        echo json_encode(array('error' => 'User not found'));
    }
}
?>
