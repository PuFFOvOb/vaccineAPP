<?php
include("connMysqli2.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    // 獲取標籤名稱
    $sql_get_label = "SELECT label FROM label_item WHERE number = $id";
    $result_get_label = mysqli_query($db_link, $sql_get_label);

    if ($result_get_label) {
        $row = mysqli_fetch_assoc($result_get_label);
        $label = $row['label'];

        // 刪除標籤
        $sql_delete_label = "DELETE FROM label_item WHERE number = $id";
        $result_delete_label = mysqli_query($db_link, $sql_delete_label);

        if ($result_delete_label) {
            // 更新最新消息標籤為空值
            $sql_update_news = "UPDATE news SET label = NULL WHERE label = '$label'";
            $result_update_news = mysqli_query($db_link, $sql_update_news);

            if ($result_update_news) {
                // 跳回最新消息介面
                header("Location: news.php");
            } else {
                // 更新消息失敗
                echo "更新消息失敗：" . mysqli_error($db_link);
            }
        } else {
            // 刪除標籤失敗
            echo "刪除標籤失敗：" . mysqli_error($db_link);
        }
    } else {
        // 獲取標籤失敗
        echo "獲取標籤失敗：" . mysqli_error($db_link);
    }
}

// 關閉資料庫連接
mysqli_close($db_link);
?>