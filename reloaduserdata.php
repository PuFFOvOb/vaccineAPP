<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">



    <title>孕婦流感疫苗管理平台</title>
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
        background-color: #f5f5f5;
        border-collapse: collapse;
        width: 100%;
        overflow: auto;
        height: 100px;
    }

    .datas-box {
        overflow: auto;
        height: 800px;
    }

    .custom-table th,
    .custom-table td {
        padding: 5px;
        text-align: center;

    }

    .custom-table th {
        background-color: #333;
        color: #fff;
    }

    .custom-table tr:nth-child(even) {
        background-color: #ddd;
    }

    .custom-table tr:hover {
        background-color: #aaa;
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

    .actions-column {
        width: 14%;
    }

    .actions-column1 {
        width: 20%;
    }
    </style>
</head>

<body>


    <main class="container mt-4">
        <section class="user-management">
            <div class="table-responsive datas-box" id="dataContainer">
                <div class="insert-btn-container">
                    <button type="button" class="btn btn-warning insert-btn "
                        onclick="window.location.href='insert_data.php'"><i
                            class='fa-solid fa-user-plus'>新增帳號</i></button>
                    <button type="button" class="btn btn-danger insert-btn" onclick="exportToCSV(true)"><i
                            class="fa-solid fa-download"></i>匯出</button>
                </div>
                <form method="post" action="update_data.php">
                    <table class="table table-bordered table-striped ">

                        <thead class="table-dark">
                            <tr>

                                <th>用戶名稱</th>

                                <th>用戶上線</th>
                                <th>用戶註冊日期</th>
                                <th>第一次測試</th>
                                <th>第二次測試</th>
                                <th>第三次測試</th>
                                <th class="actions-column">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
            include("connMysqli.php");

            $sql_query = "SELECT * FROM `user`";
            $result = mysqli_query($db_link, $sql_query);

            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>
                 
                    <td>$row[1]</td>

                    <td>$row[3]</td>
                    <td>$row[4]</td>
                    <td>$row[5]</td>
                    <td>$row[6]</td>
                    <td class='actions-column1'>$row[7]</td>
                    <td>
                        <a href='update_data.php?id=$row[0]' class='btn btn-primary  edit-btn'><i class='fa-solid fa-wrench'></i>修改</a>
                        <a href='delete_userdata.php?id=$row[0]' class='btn btn-danger delete-btn '> <i class='fas fa-trash'></i> 刪除</a>
                        
                        
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