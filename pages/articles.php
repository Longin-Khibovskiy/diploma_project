<section class="articles">
    <div class="articles_container">
        <?php
        $allArticles = GetAllArticles($link);
        array_pop($allArticles);
        array_pop($allArticles);
        if (!empty($allArticles)) {
            foreach ($allArticles as $article):?>
                <div class="article_container">
                    <svg width="22" height="30" viewBox="0 0 22 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.86674 29.3772C2.56274 29.3772 2.96503 29.0286 4.3176 27.6766L10.813 21.1943C10.8799 21.1406 10.9467 21.0869 11.0005 21.0869C11.0673 21.0869 11.1205 21.1406 11.1879 21.1943L17.6965 27.6766C19.0227 29.0023 19.4513 29.3772 20.1342 29.3772C20.9782 29.3772 21.621 28.8686 21.621 27.6497V4.81486C21.621 2.02915 20.2416 0.622864 17.469 0.622864H4.53188C1.77303 0.622864 0.379883 2.02858 0.379883 4.81486V27.6492C0.379883 28.8686 1.03645 29.3772 1.86674 29.3772ZM2.87074 26.1229C2.68331 26.3103 2.53645 26.2566 2.53645 26.0023V4.85486C2.53645 3.51544 3.25931 2.77886 4.65245 2.77886H17.3622C18.7547 2.77886 19.465 3.51601 19.465 4.85486V26.0023C19.465 26.2566 19.3176 26.2972 19.1296 26.1223L11.6707 18.744C11.4427 18.5029 11.2022 18.4354 11.001 18.4354C10.8136 18.4354 10.5725 18.5029 10.3313 18.744L2.87074 26.1229Z"
                              fill="#2C2C2C"/>
                    </svg>
                    <img src="<?= $article['imagesParts'][0] ?>" alt="" class="article_img">
                    <a href="<?php extract(PageById($link, $article['page_id'])); echo $PageLink ?>" class="article_text_container">
                        <p class="medium"><?= $article['name'] ?></p>
                        <p class="article_text small"><?php if ($article['author'] == '') echo 'Автор неизвестен';else echo $article['author'] ?></p>
                    </a>
                </div>
            <?php endforeach;
        } else echo "Все статьи ушли на модный показ. Возвращайтесь позже! 👠";
        ?>
    </div>
</section>