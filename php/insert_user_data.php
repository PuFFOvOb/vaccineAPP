<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // 引入資料庫連接檔案
    include("connMysqli.php");

    // 設定參數
    $name = $_POST["name"];
    $password = $_POST["password"];

    // 使用SQL的SELECT語句檢查是否已存在該名稱
    $checkQuery = mysqli_query($db_link, "SELECT * FROM user WHERE name = '$name'");

    if (mysqli_num_rows($checkQuery) > 0) {
        // 名稱已存在，輸出錯誤訊息
        echo "名稱已存在。";
        header("Location: insert_user_data_default.php");
    } else {
        // 名稱不存在，進行插入操作
        $result = mysqli_query($db_link, "INSERT INTO user(name, password, date) VALUES ('$name','$password', CURDATE())");

        if ($result) {
            // 插入成功，創建用戶資料表
            $stmt = mysqli_prepare($db_link, "CREATE TABLE IF NOT EXISTS `$name` (`news_number` INT PRIMARY KEY)");
            
            if ($stmt) {
                mysqli_stmt_execute($stmt);

                // 設定 news_number 初始值為 0
                $initialNewsQuery = mysqli_query($db_link, "INSERT INTO `$name` (`news_number`) VALUES (0)");

                if ($initialNewsQuery) {
                    echo "註冊成功，資料表 $name 創建成功。";
                    header("Location: userdata.php"); // 註冊成功後重定向
                    exit(); // 確保後續代碼不會執行
                } else {
                    echo "註冊成功，但初始化 news_number 失敗：" . mysqli_error($db_link);
                }

                // 關閉 prepared statement
                mysqli_stmt_close($stmt);
            } else {
                echo "Prepared statement error: " . mysqli_error($db_link);
            }
        } else {
            // 插入失敗
            echo "註冊失敗：" . mysqli_error($db_link);
        }
    }

    // 關閉資料庫連接
    mysqli_close($db_link);
}
?>
