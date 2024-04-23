<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">



    <title>管理員介面</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <style>
    body {
        /*畫面設置 */

        background-image: url('封面.png');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        font-family: Arial, sans-serif;
    }

    /* 自定義表格樣式 */
    .custom-table {

        border-collapse: collapse;
        width: 100%;
        overflow: auto;
        height: 100px;
    }

    .custom-table th,
    .custom-table td {
        padding: 6px;
        text-align: center;
    }

    .news-box {
        overflow: auto;
        height: 700px;
    }


    .update-btn-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 10px;
    }

    .update-btn {
        width: 140px;
        height: 40px;
        color: #fff;
    }

    .insert-btn-container {
        display: flex;
        justify-content: flex-end;
        margin-top: 10px;
    }

    .insert-btn {
        width: 120px;
        height: 40px;
        color: #fff;
    }

    .font-size {
        font-size: 30px
    }

    .actions-column {
        width: 15%;
    }

    .actions-column1 {
        width: 40%;
    }
    </style>
</head>

<body>


    <main class="container mt-4">
        <section class="user-management">

            <div class="table-responsive " id="dataContainer">
                <form method="post" action="update_news_to_app.php">
                    <div class="update-btn-container">
                        <button type="submit" class="btn btn-warning update-btn"><i
                                class='fa-solid fa-circle-up'></i>改變發布狀態</button>
                    </div>
                    <div class="news-box">
                        <table class="table table-bordered table-striped custom-table ">

                            <thead class="table-danger text-center opacity-75  ">
                                <tr>
                                    <th>編號</th>
                                    <th>標籤</th>
                                    <th>日期</th>
                                    <th>標題</th>
                                    <th>連結</th>
                                    <th>類型</th>
                                    <th>點閱次數</th>
                                    <th>是否發布</th>
                                    <th></th>
                                    <th class="actions-column">操作</th>
                                </tr>
                            </thead>
                            <tbody class="table-light  ">
                                <?php
                                include("connMysqli2.php");

                                $sql_query = "SELECT * FROM `news` ORDER BY `news`.`number` DESC";
                                $result = mysqli_query($db_link, $sql_query);

                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<tr>
                                    <td>$row[0]</td> 
                                    <td>$row[1]</td>
                                    <td>$row[2]</td>
                                    <td>$row[3]</td>
                                    <td>$row[4]</td>
                                    <td>$row[5]</td>
                                    <td>$row[6]</td>
                                    <td>$row[7]</td>
                            <td> <input type='checkbox' name='checkbox[]' value='$row[0]'>

                            </td>
                            <td>
                                <a href='update_news.php?id=$row[0]' class='btn btn-primary'><i
                                        class='fa-solid fa-wrench'></i>修改</a>
                                <a href='delete_news.php?id=$row[0]' class='btn btn-danger'> <i
                                        class='fas fa-trash'></i> 刪除</a>
                            </td>
                            </tr>";
                            }
                            ?>
                            </tbody>

                        </table>
                    </div>
            </div>
            </form>
            </div>
        </section>
        <section class="user-management">
            <h2 class="mb-4">標籤管理</h2>
            <div class="table-responsive" id="dataContainer">
                <form method="post" action="">
                    <div class="insert-btn-container">
                        <button type="button" class="btn btn-warning insert-btn "
                            onclick="window.location.href='insert_label.php'"><i
                                class='fa-solid fa-user-plus'>新增標籤</i></button>
                    </div>
                    <table class="table table-bordered table-striped custom-table">

                        <thead class="table-danger  text-center  ">
                            <tr>
                                <th class="actions-column1">標籤</th>
                                <th class="actions-column">操作</th>
                            </tr>
                        </thead>
                        <tbody class="table-light  ">
                            <?php
                                include("connMysqli2.php");

                                $sql_query = "SELECT * FROM `label_item`";
                                $result = mysqli_query($db_link, $sql_query);

                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<tr> 
                                    <td class='font-size'>$row[1]</td>
                                    <td>
                                    <a href='update_label.php?id=$row[0]' class='btn btn-primary'><i
                                        class='fa-solid fa-wrench'></i>修改</a>
                                    <a href='delete_label.php?id=$row[0]' class='btn btn-danger'> <i
                                        class='fas fa-trash'></i> 刪除</a>
                                    </td>   
                                    </tr>";
                                }
                            ?>
                        </tbody>
                    </table>

                </form>

            </div>
        </section>
    </main>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>

</html>