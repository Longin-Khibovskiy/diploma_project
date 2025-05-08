<?php
global $link;

$envPath = dirname(__DIR__) . '/.env';
if (!file_exists($envPath)) {
    die(".env  файл не найден по пути $envPath");
}

$env = parse_ini_file($envPath);

$requiredVars = ['DB_HOST', 'DB_USER', 'DB_PASS', 'DB_NAME'];
foreach ($requiredVars as $var) {
    if (!isset($env[$var])) {
        die("Переменная $var не задана в файле .env.");
    }
}

$link = mysqli_connect($env['DB_HOST'], $env['DB_USER'], $env['DB_PASS'], $env['DB_NAME']);

if ($link === false) {
    die('Ошибка: Невозможно подключиться к MySQL ' . mysqli_connect_error());
}
?>