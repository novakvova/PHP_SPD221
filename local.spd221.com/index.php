<?php global $dbh; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Користвувачі</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/site.css">
</head>
<body>
    <?php include $_SERVER["DOCUMENT_ROOT"]."/_header.php"; ?>
    <?php include $_SERVER["DOCUMENT_ROOT"]."/connection_database.php"; ?>

    <div class="container">
        <h1 class="text-center">
            Список користувачів
        </h1>

        <table class="table">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">ПІБ</th>
                <th scope="col">Фото</th>
                <th scope="col">Пошта</th>
                <th scope="col">Телефон</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql = 'SELECT * FROM users';
            foreach ($dbh->query($sql) as $row) {
                $id = $row["id"];
                $name = $row["name"];
                $image = $row["image"];
                $email = $row["email"];
                $phone = $row["phone"];
                echo "
            <tr>
                <th scope='row'>$id</th>
                <td>$name</td>
                <td>
                    <img src='$image'
                         alt='$name' width='150'>
                </td>
                <td>$email</td>
                <td>$phone</td>
            </tr>
                ";
            }
            ?>
            </tbody>
        </table>
    </div>

    <script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
