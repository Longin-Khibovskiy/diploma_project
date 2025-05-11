<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_article'])) {
    header('Content-Type: application/json');

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

        // Выполняем запрос
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
                    <svg class="save-icon <?= in_array($article['id'], $savedArticles) ? 'saved' : '' ?>" width="22"
                         height="29" viewBox="0 0 22 29" onclick="toggleSave(<?= $article['id'] ?>)" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.48686 28.7543C2.18286 28.7543 2.58514 28.4057 3.93771 27.0537L10.4331 20.5714C10.5 20.5177 10.5669 20.464 10.6206 20.464C10.6874 20.464 10.7406 20.5177 10.808 20.5714L17.3166 27.0537C18.6429 28.3794 19.0714 28.7543 19.7543 28.7543C20.5983 28.7543 21.2411 28.2457 21.2411 27.0269V4.192C21.2411 1.40629 19.8617 0 17.0891 0H4.152C1.39314 0 0 1.40571 0 4.192V27.0263C0 28.2457 0.656572 28.7543 1.48686 28.7543ZM2.62012 24.8771C2.43269 25.0646 3.12012 25.6314 3.12012 25.3771L10.808 18.8771C10.808 17.5377 5.75398 21.4977 7.14712 21.4977L3.12012 25.3771C4.51269 25.3771 10.808 17.5383 10.808 18.8771L18.3335 26.0951C18.3335 26.3494 18.9377 25.6743 18.7497 25.4994L11.2909 18.1211C11.0629 17.88 11.0091 18.8771 10.808 18.8771C10.6206 18.8771 10.1926 17.88 9.95143 18.1211L2.62012 24.8771Z"
                              fill="#2C2C2C"/>
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
            window.location.href = '/authorisation';
        }
        <?php endif; ?>
    }
</script>