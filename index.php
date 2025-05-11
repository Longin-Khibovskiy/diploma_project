<?php
require_once './config/connect.php';
require_once './config/settings.php';

$page = $_GET['page'] ?? 'index';
$pagePath = 'pages/' . $page . '.php';
if ($page != 'authorisation' && $page != 'registration') {
    include './tpl/header.php';
}
if (file_exists($pagePath)) include $pagePath; else include 'pages/404.php';

if ($page != 'authorisation' && $page != 'registration') {
    include './tpl/footer.php';
}
?>