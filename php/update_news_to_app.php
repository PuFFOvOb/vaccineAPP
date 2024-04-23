<?php

include("connMysqli2.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["checkbox"])) {
        foreach ($_POST["checkbox"] as $newsId) {
            // 獲取現在狀態
            $currentStatusQuery = "SELECT `setting` FROM `news` WHERE `number` = $newsId";
            $result = mysqli_query($db_link, $currentStatusQuery);
            
            if ($result) {
                $row = mysqli_fetch_array($result);
                $currentStatus = $row['setting'];

                // 切換發布狀態
                $newStatus = $currentStatus == 1 ? 0 : 1;

                // 更新資料庫
                $updateQuery = "UPDATE `news` SET `setting` = $newStatus WHERE `number` = $newsId";
                mysqli_query($db_link, $updateQuery);
            } else {
                echo "查詢狀態錯誤。";
            }
        }
        header("Location: news.php");
    } else {
        echo "未選擇資料。";
    }

    mysqli_close($db_link);
}?>