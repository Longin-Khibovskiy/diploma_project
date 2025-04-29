<?php require_once './config/connect.php'?>
<?php include './tpl/header.php'?>
<?php
if (!isset($_GET['page'])) {
    include 'pages/index.php';
} else if (file_exists('pages/'.$_GET['page'].'.php')) {
    include 'pages/'.$_GET['page'].'.php';
} else {
    include 'pages/404.php';
} ?>
<?php include 'tpl/footer.php' ?>