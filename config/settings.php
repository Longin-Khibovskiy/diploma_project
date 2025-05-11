<?php
function NewTable($conn, $sql, $name_of_table)
{
    if ($conn->query($sql) === TRUE) {
        echo "Таблица $name_of_table создана успешно.\n";
    } else {
        die("Ошибка создания таблицы $name_of_table: " . $conn->error);
    }
}

function generateImages(array $config): array
{
    $result = [];
    foreach ($config as $key => $params) {
        $images = [];
        $range = ($params['step'] > 0)
            ? range($params['start'], $params['end'], $params['step'])
            : range($params['start'], $params['end']);
        foreach ($range as $i) {
            $images[] = sprintf('../images/%s/%s-%d.png', $params['path'], $params['prefix'], $i);
        }
        $result[$key] = implode(', ', $images);
    }
    return $result;
}

function PagesLinks($link)
{
    $currentPage = $_GET['page'] ?? 'index';

    $sql = 'SELECT name, link FROM Pages';
    $result = mysqli_query($link, $sql);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $rows = array_slice($rows, 0, 5);

    $html = '';
    foreach ($rows as $row) {
        if ($currentPage === 'index') {
            $isActive = ($row['link'] === '/') ? 'active' : '';
        } else {
            $isActive = ($row['link'] === '/' . $currentPage) ? 'active' : '';
        }

        $html .= sprintf(
            '<a href="%s" class="%s">%s</a>',
            htmlspecialchars($row['link'] ?? '#'),
            htmlspecialchars("nav_link $isActive"),
            htmlspecialchars($row['name'] ?? '')
        );
    }
    return $html;
}


function FindById($link, $id)
{
    $id = (int)$id;
    $sql = "SELECT * FROM HomeArticles WHERE id = $id";
    $result = $link->query($sql);
    if (!$result || $result->num_rows === 0) {
        return null;
    }
    $row = $result->fetch_assoc();
    return [
        'title' => htmlspecialchars($row['title'] ?? ''),
        'author' => htmlspecialchars($row['author'] ?? ''),
        'descriptionParts' => array_map('trim', array_filter(explode('/', $row['description'] ?? ''))),
        'imagesParts' => array_map('trim', array_filter(explode(',', $row['images'] ?? '')))
    ];
}

function FindArticles($link, $id)
{
    $id = (int)$id;
    $sql = "SELECT * FROM Articles WHERE id = $id";
    $result = $link->query($sql);
    if (!$result || $result->num_rows === 0) {
        return null;
    }
    $row = $result->fetch_assoc();
    return [
        'name' => htmlspecialchars($row['name'] ?? ''),
        'author' => htmlspecialchars($row['author'] ?? ''),
        'descriptionParts' => array_map('trim', array_filter(explode('/', $row['description'] ?? ''))),
        'imagesParts' => array_map('trim', array_filter(explode(',', $row['images'] ?? '')))
    ];
}

function ShowSvgIcons($folder = 'images/icons/')
{
    $links = [
        'instagram' => 'https://instagram.com',
        'facebook' => 'https://facebook.com',
        'twitter' => 'https://x.com',
        'pinterest' => 'https://pinterest.com',
        'telegram' => 'https://t.me/longin_kh'
    ];
    $files = scandir($folder);
    $html = '';

    foreach ($files as $file) {
        if (in_array($file, ['.', '..'])) continue;
        $icon_name = pathinfo($file, PATHINFO_FILENAME);
        $icon_url = $links[$icon_name];

        $html .= sprintf(
            '<a href="%s" target="_blank"><img src="%s" class="footer_icon" alt="%s"></a>',
            htmlspecialchars($icon_url),
            htmlspecialchars($folder . $file),
            htmlspecialchars($icon_name)
        );
    }
    return $html;
}

function GetAllArticles($link)
{
    $sql = "SELECT * FROM Articles";
    $result = $link->query($sql);

    $articles = [];
    while ($row = $result->fetch_assoc()) {
        $articles[] = [
            'id' => (int)$row['id'],
            'name' => htmlspecialchars($row['name'] ?? 'Без названия'),
            'author' => htmlspecialchars($row['author'] ?? 'Автор неизвестен'),
            'descriptionParts' => array_filter(
                explode('/', $row['description'] ?? ''),
                function ($part) {
                    return trim($part) !== '';
                }
            ),
            'imagesParts' => array_filter(
                explode(',', $row['images'] ?? ''),
                function ($img) {
                    return trim($img) !== '';
                }
            ),
            'page_id' => htmlspecialchars($row['pages_id'] ?? '')
        ];
    }
    return $articles;
}

function PageById($link, $id)
{
    $sql = "SELECT * FROM Pages WHERE id = $id";
    $result = $link->query($sql);
    if (!$result || $result->num_rows === 0) {
        return null;
    }
    $row = $result->fetch_assoc();
    return [
        'PageName' => htmlspecialchars($row['name'] ?? ''),
        'PageDescription' => htmlspecialchars($row['description'] ?? ''),
        'PageLink' => htmlspecialchars($row['link'] ?? '')
    ];
}

## Регистрация
function RegisterUser($link, $email, $username, $password)
{
    $email = $link->real_escape_string($email);
    $username = $link->real_escape_string($username);
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $sql = "SELECT id FROM users WHERE email = '$email' OR username = '$username' LIMIT 1";
    $result = $link->query($sql);
    if ($result && $result->num_rows > 0) return false;

    $sql = "INSERT INTO users (email, username, password_hash) 
            VALUES ('$email', '$username', '$password_hash')";

    if ($link->query($sql)) {
        return $link->insert_id;
    }
}

## Аутентификация пользователя
function LoginUser($link, $loginOrEmail, $password)
{
    $loginOrEmail = $link->real_escape_string($loginOrEmail);

    $sql = "SELECT id, username, password_hash FROM users WHERE email = '$loginOrEmail' OR username = '$loginOrEmail' LIMIT 1";
    $result = $link->query($sql);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['user'] = ['id' => $user['id'], 'username' => $user['username']];
            return 'success';
        } else return 'invalid_password';
    } else return 'user_not_found';
}