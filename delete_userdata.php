<?php
include("connMysqli.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];

    // 準備並執行語句以獲取使用者名稱
    $stmt = mysqli_prepare($db_link, "SELECT name FROM user WHERE userId = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        $username = $row['name'];

        // 準備並執行語句以刪除使用者帳戶
        $stmtDeleteUser = mysqli_prepare($db_link, "DELETE FROM `user` WHERE userId = ?");
        mysqli_stmt_bind_param($stmtDeleteUser, "i", $id);

        if (mysqli_stmt_execute($stmtDeleteUser)) {
            // 使用者帳戶刪除成功
            echo "使用者帳戶刪除成功。";

            // 準備並執行語句以刪除使用者資料表
            $stmtDropTable = mysqli_prepare($db_link, "DROP TABLE IF EXISTS `$username`");
            mysqli_stmt_execute($stmtDropTable);

            // 重定向到原始介面
            header("Location: userdata.php");
        } else {
            // 使用者帳戶刪除失敗
            echo "使用者帳戶刪除失敗：" . mysqli_error($db_link);
        }
    } else {
        // 無法檢索使用者名稱
        echo "無法檢索使用者名稱：" . mysqli_error($db_link);
    }

    // 關閉準備好的語句
    mysqli_stmt_close($stmt);
    mysqli_stmt_close($stmtDeleteUser);
    mysqli_stmt_close($stmtDropTable);
}

// 關閉資料庫連接
mysqli_close($db_link);
?>