<?php
$db_host = "localhost";
$db_username = "root";
$db_password = "!QAZ2wsx";
$db_link = mysqli_connect($db_host, $db_username, $db_password);

if (!$db_link) {
    die('資料庫連結失敗: ' . mysqli_connect_error());
}

mysqli_query($db_link, "SET NAMES 'utf8'");

$seldb = mysqli_select_db($db_link, "app");

if (!$seldb) {
    die('資料庫選擇失敗: ' . mysqli_error($db_link));
}