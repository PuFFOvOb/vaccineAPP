<?php
    $db_host = "localhost";
    $db_username = "root";
    $db_password = "123";
    $db_link=mysqli_connect($db_host,$db_username,$db_password);
    mysqli_query($db_link,"SET NAMES 'utf8'");
    if(!$db_link) echo '資料庫連結失敗';
    $seldb = mysqli_select_db($db_link,"app");
    if(!$seldb) echo '資料庫選擇失敗';
?>