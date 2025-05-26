<?php
require_once './config/connect.php';
require_once './config/settings.php';

$page = $_GET['page'] ?? 'index';
$page = preg_replace('/[^a-zA-Z0-9_\-\/]/', '', $page);
if (!file_exists("pages/{$page}.php") && is_dir("pages/{$page}")) {
    $page .= '/index';
}
$pagePath = 'pages/' . $page . '.php';
if ($page != 'user/authorisation' && $page != 'user/registration' && $page != 'admin/index') {
    include './tpl/header.php';
}
if ($page === 'admin/index') include './tpl/_head.php';
if (file_exists($pagePath)) include $pagePath; else include 'pages/404.php';

if ($page != 'user/authorisation' && $page != 'user/registration' && $page != 'admin') {
    include './tpl/footer.php';
}
?>