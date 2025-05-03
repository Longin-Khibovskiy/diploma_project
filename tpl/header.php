<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="../stylesheet/style.css">
    <script src="../js/main.js" defer></script>
</head>
<body>
<header>
    <div class="header_container">
        <div class="nav_container">
            <?php
            $sql = 'SELECT * FROM pages';
            $result = mysqli_query($link, $sql);
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
            array_pop($rows);
            foreach ($rows as $row) :?>
                <a href="<?php echo $row['link']?>" class="nav_link"><?php echo $row['name']?></a>
            <?php endforeach ?>
        </div>
        <a href=""><button class="header_button">Войти</button></a>
    </div>
</header>