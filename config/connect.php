<?php
global $link;

if (!file_exists(__DIR__ . '/.env')) {
    die('.env file not found. Create it and define DB_HOST, DB_USER, DB_PASS, DB_NAME.');
}
$env = parse_ini_file(__DIR__ . '/.env');
$requiredVars = ['DB_HOST', 'DB_USER', 'DB_PASS', 'DB_NAME'];
foreach ($requiredVars as $var) {
    if (!isset($env[$var])) {
        die("Environment variable $var is not set.");
    }
}
$link = mysqli_connect($env['DB_HOST'], $env['DB_USER'], $env['DB_PASS'], $env['DB_NAME']);

if ($link == false) {
    print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
}
?>