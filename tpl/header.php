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
    $currentPage = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['page'] ?? '');
    $cssPath = "stylesheet/{$currentPage}.css";
    if (file_exists($cssPath)) {
        echo "<link rel='stylesheet' href='/{$cssPath}'>";
    }
    ?>
    <script src='https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js' defer></script>
    <script src="/js/main.js" defer></script>
</head>
<body>
<button class="up" id="button-up">
    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="32" viewBox="0 0 26 32" fill="none">
        <path d="M25.3705 10.3985L16.0549 1.24141C15.2431 0.446295 14.1449 0 13.0002 0C11.8556 0 10.7574 0.446295 9.94559 1.24141L0.629979 10.3985C0.226481 10.7985 0 11.3395 0 11.9034C0 12.4673 0.226481 13.0083 0.629979 13.4082C0.831376 13.6083 1.07098 13.7671 1.33498 13.8755C1.59898 13.9838 1.88215 14.0396 2.16814 14.0396C2.45413 14.0396 2.7373 13.9838 3.00129 13.8755C3.26529 13.7671 3.5049 13.6083 3.7063 13.4082L10.8338 6.38563V29.8655C10.8338 30.4316 11.0621 30.9745 11.4684 31.3748C11.8746 31.7751 12.4257 32 13.0002 32C13.5748 32 14.1259 31.7751 14.5321 31.3748C14.9384 30.9745 15.1667 30.4316 15.1667 29.8655V6.38563L22.2942 13.4082C22.6993 13.8102 23.2498 14.0371 23.8247 14.0391C24.3996 14.0411 24.9517 13.818 25.3597 13.4189C25.7676 13.0198 25.998 12.4774 26 11.9109C26.002 11.3445 25.7756 10.8005 25.3705 10.3985V10.3985Z"
              fill="#2C2C2CFF"/>
    </svg>
</button>
<header>
    <div class="header_container">
        <div class="nav_container">
            <?= PagesLinks($link) ?>
        </div>
        <a href="/authorisation">
            <button class="header_button">Войти</button>
        </a>
    </div>
</header>