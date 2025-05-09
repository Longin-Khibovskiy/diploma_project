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
    array_pop($rows);

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