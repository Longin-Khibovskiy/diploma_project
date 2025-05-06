<?php
function FindById($link, $id)
{
    $id = (int)$id;
    $sql = "SELECT * FROM HomeArticles WHERE id = $id";
    $result = $link->query($sql);
    if (!$result || $result->num_rows === 0) {
        return null;
    }
    $row = $result->fetch_assoc();
//    $title = $row['title'];
//    $author = $row['author'];
//    $description = $row['description'];
//    $images = $row['images'];
//    $descriptionParts = array_filter(explode('/', $description));
//    $descriptionParts = array_map('trim', $descriptionParts);
//    $imagesParts = array_map('trim', array_filter(explode(',', $images)));
    return [
        'title' => htmlspecialchars($row['title'] ?? ''),
        'author' => htmlspecialchars($row['author'] ?? ''),
        'descriptionParts' => array_map('trim', array_filter(explode('/', $row['description'] ?? ''))),
        'imagesParts' => array_map('trim', array_filter(explode(',', $row['images'] ?? '')))
    ];
}