<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Collaboration</title>
    <link rel="icon" href="/images/logo.png">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css'>
    <link rel="stylesheet" href="/stylesheet/index.css">
    <?php
    $page = $_GET['page'] ?? '';
    $page = preg_replace('/[^a-zA-Z0-9_\-\/]/', '', $page);
    if (is_dir("pages/{$page}") && is_dir("pages/{$page}.php")) $page .= '/index';
    if (str_starts_with($page, 'admin/')) {
        $subpage = basename($page);
        $cssPath = "stylesheet/admin/{$subpage}.css";
    } else $cssPath = "stylesheet/{$page}.css";

    if (file_exists($cssPath)) echo "<link rel='stylesheet' href='/{$cssPath}'>";
    ?>
    <link rel="stylesheet" href="/stylesheet/adaptive.css">
    <script src='https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js' defer></script>
    <script src="/js/main.js" defer></script>
</head>