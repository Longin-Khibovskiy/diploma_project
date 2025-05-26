<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_article'])) {
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
    $action = $_POST['action'] ?? 'save';

    try {
        $stmt = $link->prepare("SELECT id FROM Articles WHERE id = ?");
        $stmt->bind_param('i', $articleId);
        $stmt->execute();
        if (!$stmt->get_result()->num_rows) throw new Exception('Статья не найдена');

        if ($action === 'save') $sql = "INSERT INTO SavedArticles (user_id, article_id) VALUES (?, ?)";
        else $sql = "DELETE FROM SavedArticles WHERE user_id = ? AND article_id = ?";

        $stmt = $link->prepare($sql);
        $stmt->bind_param('ii', $userId, $articleId);
        if (!$stmt->execute()) throw new Exception('Ошибка базы данных');

        echo json_encode([
            'success' => true,
            'action' => $action,
        ]);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

$savedArticles = [];
if (isset($_SESSION['user'])) {
    $userId = (int)$_SESSION['user']['id'];
    $stmt = $link->prepare("SELECT article_id FROM SavedArticles WHERE user_id = ?");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $savedArticles[] = $row['article_id'];
    }
}

if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

$allArticles = GetAllArticles($link);
array_pop($allArticles);
array_pop($allArticles);
?>
<section class="articles">
    <div class="articles_container">
        <h3>Новости и вдохновение</h3>
        <?php
        if (!empty($allArticles)) {
            foreach ($allArticles as $article):?>
                <div class="article_container" data-article-id="<?= $article['id'] ?>"
                     data-saved="<?= in_array($article['id'], $savedArticles) ? 'true' : 'false' ?>">
                    <svg class="save-icon <?= in_array($article['id'], $savedArticles) ? 'saved' : '' ?>" xmlns="http://www.w3.org/2000/svg" width="23" height="32" viewBox="0 0 23 32" fill="none" onclick="toggleSave(<?= $article['id'] ?>)">
                        <path d="M21.1601 28.3468V1.77441H1.83826V28.3468L11.2701 20.8001L21.1601 28.3468Z" stroke="black" stroke-width="3"/>
                    </svg>
                    <img src="<?= $article['imagesParts'][0] ?>" alt="" class="article_img">
                    <a href="<?php extract(PageById($link, $article['page_id']));
                    echo $PageLink ?>" class="article_text_container">
                        <p class="medium"><?= $article['name'] ?></p>
                        <p class="article_text small"><?php if ($article['author'] == '') echo 'Автор неизвестен'; else echo $article['author'] ?></p>
                    </a>
                </div>
            <?php endforeach;
        } else echo "Все статьи ушли на модный показ. Возвращайтесь позже! 👠";
        ?>
    </div>
</section>

<script>
    function toggleSave(articleId) {
        <?php if (isset($_SESSION['user'])): ?>
        const articleDiv = document.querySelector(`[data-article-id="${articleId}"]`);
        const icon = articleDiv.querySelector('.save-icon');
        const isSaved = articleDiv.dataset.saved === 'true';
        const action = isSaved ? 'delete' : 'save';

        const formData = new FormData();
        formData.append('save_article', '1');
        formData.append('article_id', articleId);
        formData.append('action', action);
        formData.append('csrf_token', '<?= $_SESSION['csrf_token'] ?>');

        articleDiv.dataset.saved = !isSaved;
        icon.classList.toggle('saved', !isSaved);

        fetch('', {
            method: 'POST',
            body: formData
        })
        <?php else: ?>
        if (confirm('Для сохранения статей войдите в систему!')) {
            window.location.href = '/user/authorisation';
        }
        <?php endif; ?>
    }
</script>