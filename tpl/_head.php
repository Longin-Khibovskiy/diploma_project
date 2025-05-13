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
    $currentPage = preg_replace('/[^a-zA-Z0-9_\-\/]/', '', $_GET['page'] ?? '');
    $cssPath = "stylesheet/{$currentPage}.css";
    if (file_exists($cssPath)) echo "<link rel='stylesheet' href='/{$cssPath}'>";
    ?>
    <script src='https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js' defer></script>
    <script src="/js/main.js" defer></script>
</head>