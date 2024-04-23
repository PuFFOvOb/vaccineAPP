<?php 
include("connMysqli2.php");
if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
   

    // sql更新資料語法
    $sql = "UPDATE `ctr` SET `updateNews_ctr`='0' ";


    if (mysqli_query($db_link, $sql)) {
        // 更新成功
        echo "用戶編號 $number 更新成功。<br>";
        header("Location: ctr.php"); // 成功更新後跳回首頁
        // 確保code到這中斷
    } else {
        // 更新失败
        echo "用戶編號 $number 更新失敗" . mysqli_error($db_link) . "<br>";
    }
}

mysqli_close($db_link);
?>