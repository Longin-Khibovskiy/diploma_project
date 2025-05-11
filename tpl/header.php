<?php require_once '_head.php' ?>
<body>
<button class="up" id="button-up">
    <svg width="26" height="15" viewBox="0 0 26 15" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M24.1237 15L13 3.78378L1.87629 15L0 13.1081L13 0L26 13.1081L24.1237 15Z"/>
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