<?php
require_once './config/connect.php';
require_once './config/settings.php';
include './tpl/header.php';

$page = $_GET['page'] ?? 'index';
$pagePath = 'pages/' . $page . '.php';

if (file_exists($pagePath)) include $pagePath; else include 'pages/404.php';

include './tpl/footer.php';
?>