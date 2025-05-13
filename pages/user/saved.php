<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_article'])) {
    if (!isset($_SESSION['user'])) {
        echo json_encode(['error' => 'Требуется авторизация']);
        exit;
    }

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode(['error' => 'Ошибка безопасности']);
        exit;
    }

    $articleId = (int)$_POST['article_id'];
    $userId = (int)$_SESSION['user']['id'];

    try {
        $stmt = $link->prepare("DELETE FROM SavedArticles WHERE user_id = ? AND article_id = ?");
        $stmt->bind_param('ii', $userId, $articleId);

        if (!$stmt->execute()) throw new Exception('Ошибка базы данных');

        echo json_encode([
            'success' => true,
            'action' => 'delete',
            'articleId' => $articleId
        ]);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

$savedArticlesData = [];
if (isset($_SESSION['user'])) {
    $userId = (int)$_SESSION['user']['id'];
    $stmt = $link->prepare("
        SELECT a.id, a.name, a.author, a.images, a.pages_id
        FROM SavedArticles AS s
        JOIN Articles AS a ON s.article_id = a.id
        WHERE s.user_id = ?
        ORDER BY s.saved_at DESC
    ");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $row['imagesParts'] = explode(',', $row['images'] ?? '') ?: ['default.jpg'];
        $savedArticlesData[] = $row;
    }
}

if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
?>
<section class="users_saved">
    <div class="users_saved_container">
        <h3>Сохраненные статьи</h3>
        <?php if (!empty($savedArticlesData)): ?>
            <?php foreach ($savedArticlesData as $article): ?>
                <div class="user_saved_container" data-article-id="<?= $article['id'] ?>">
                    <svg class="save-icon saved" xmlns="http://www.w3.org/2000/svg" width="23"
                         height="32" viewBox="0 0 23 32" fill="none" onclick="toggleSave(<?= $article['id'] ?>)">
                        <path d="M21.1601 28.3468V1.77441H1.83826V28.3468L11.2701 20.8001L21.1601 28.3468Z"
                              stroke="black" stroke-width="3"/>
                    </svg>
                    <img src="<?= $article['imagesParts'][0] ?>" alt="" class="user_saved_img">
                    <a href="<?php extract(PageById($link, $article['pages_id']));
                    echo $PageLink; ?>"
                       class="user_saved_text_container">
                        <p class="medium"><?= htmlspecialchars($article['name']) ?></p>
                        <p class="user_saved_text small"><?= htmlspecialchars($article['author'] ?: 'Автор неизвестен') ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="user_saved_zero_message">😢 Ваша коллекция пуста. Сохраняйте понравившиеся статьи!</p>
        <?php endif; ?>
    </div>
</section>

<script>
    function toggleSave(articleId) {
        <?php if (isset($_SESSION['user'])): ?>
        const articleDiv = document.querySelector(`[data-article-id="${articleId}"]`);
        const formData = new FormData();


        formData.append('remove_article', '1');
        formData.append('article_id', articleId);
        formData.append('csrf_token', '<?= $_SESSION['csrf_token'] ?>');
        articleDiv.remove();
        fetch('', {
            method: 'POST',
            body: formData
        })
        window.location.reload()
        <?php else: ?>
        if (confirm('Для сохранения статей войдите в систему!')) {
            window.location.href = '/authorisation';
        }
        <?php endif; ?>
    }
</script>