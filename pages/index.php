<section class="home">
    <?php
    $pageName = "Главная";
    $sql = "SELECT description FROM Pages WHERE name = '$pageName'";
    $result = $link->query($sql);
    if ($result && $result->num_rows > 0) :
        $row = $result->fetch_assoc();
        $description = $row['description'];
        $words = explode(" ", $description);
        if (count($words) > 0) :
            $firstWord = htmlspecialchars(array_shift($words));
            $otherText = htmlspecialchars(implode(" ", $words));
            ?>
            <div class="title_grid">
                <h1 class="page_title"><?= $firstWord ?></h1>
                <div class="author_container">
                    <p class="author_page">«от Сальвадора Дали и Schiaparelli до H&M и Mugler»</p>
                </div>
                <div class="second_paragraph">
                    <h2 class="page_title"><?= $otherText ?></h2>
                </div>
            </div>
        <?php
        endif;
    endif;
    ?>
    <div class="home_video">
        <video src="../video/main.mp4" autoplay loop muted></video>
    </div>
    <div class="first_description_home_page_container">
        <p class="first_description_home_page">Модных тандемов сегодня настолько много, что пора заводить на них уже
            отдельный толковый словарь. Тиффани и Суприм, Суприм и Луи Виттон, Луи Виттон и Найк, Найк и Диор, Диор и
            Биркеншток. А Биркеншток ещё с десятком других люксовых гигантов. Перечислять кто, с кем, когда и зачем
            можно до Луны и обратно.</p>
    </div>
    <div class="description_home_page_container">
        <p class="second_description_home_page">Давайте вспомним самые громкие кейсы и в конце концов поймём, как же все
            это произошло и как стало главным событием в индустрии.</p>
    </div>
    <div class="whats_collaboration">
        <?php extract(FindById($link, 1)); ?>
        <h3><?= $title ?></h3>
        <div class="whats_container">
            <div class="whats_left">
                <p class="whats_first_text"><?= $descriptionParts[0] ?></p>
                <?php foreach (array_slice($descriptionParts, 1, 2) as $part) : ?>
                    <p class="whats_other_text"><?= $part ?></p>
                <?php endforeach ?>
                <img src="<?= $imagesParts[0] ?>" alt="" class="whats_left_img">
            </div>
            <div class="whats_right">
                <img src="<?= $imagesParts[1] ?>" alt="" class="whats_first_right_img">
                <p class="whats_right_text"><?= $descriptionParts[3] ?></p>
                <div class="whats_imgs_container">
                    <?php foreach (array_slice($imagesParts, 2, 2) as $part) : ?>
                        <img src="<?= $part ?>" alt="" class="whats_right_img">
                    <?php endforeach ?>
                    <div class="whats_amazing_img">
                        <img src="<?= $imagesParts[4] ?>" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="width_container_timberwolf">
        <div class="art_fashion">
            <?php extract(FindById($link, 2)); ?>
            <h3><?= $title ?></h3>
            <div class="art_fashion_container max-screen">
                <?php for ($i = 0; $i <= 2; $i++): ?>
                    <p><?= $descriptionParts[$i] ?></p>
                    <img src="<?= $imagesParts[$i] ?>" alt="">
                <?php endfor ?>
            </div>
            <div class="art_fashion_container min-screen">
                <p><?= $descriptionParts[0] ?></p>
                <img src="<?= $imagesParts[1] ?>" alt="">
                <p><?= $descriptionParts[2] ?></p>
                <img src="<?= $imagesParts[0] ?>" alt="">
                <p><?= $descriptionParts[1] ?></p>
                <img src="<?= $imagesParts[2] ?>" alt="">
            </div>
            <div class="art_fashion_button_container">
                <a href="/articles/art_fashion" class="link_for_button">
                    <button class="hover_button_black_orange">Подробнее</button>
                </a>
            </div>
        </div>
    </div>
    <div class="houses_and_artists">
        <?php extract(FindById($link, 3)); ?>
        <div class="houses_and_artists_title_container" id="Louis Vuitton">
            <h3><?= $title ?></h3>
            <p><?= $author ?></p>
        </div>
        <div class="houses_first_container">
            <div class="houses_first_text_container">
                <?php foreach (array_slice($descriptionParts, 0, 3) as $part) : ?>
                    <p class="houses_first_text"><?= $part ?></p>
                <?php endforeach ?>
            </div>
            <video src="../video/fashion_house_1.mp4" autoplay loop muted></video>
        </div>
        <div class="houses_imgs_container">
            <?php foreach (array_slice($imagesParts, 1, 2) as $part) : ?>
                <img src="<?= $part ?>" alt="">
            <?php endforeach ?>
        </div>
        <div class="house_second_container">
            <video src="../video/fashion_house_2.mp4" autoplay loop muted class="house_second_img"></video>
            <div class="house_second_text_container">
                <?php foreach (array_slice($descriptionParts, 3, 3) as $part) : ?>
                    <p class="houses_second_text"><?= $part ?></p>
                <?php endforeach ?>
            </div>
        </div>
        <div class="house_third_container">
            <div class="house_third_text_container" id="Dior">
                <?php foreach (array_slice($descriptionParts, 6, 2) as $part) : ?>
                    <p class="houses_third_text"><?= $part ?></p>
                <?php endforeach ?>
            </div>
            <?php foreach (array_slice($imagesParts, 4, 2) as $part) : ?>
                <img src="<?= $part ?>" alt="">
            <?php endforeach ?>
        </div>
        <div class="house_last_container">
            <video src="../video/fashion_house_3.mp4" autoplay loop muted></video>
        </div>
    </div>
    <div class="width_container_isabelline">
        <div class="lux">
            <?php extract(FindById($link, 4)); ?>
            <div class="lux_title_container" id="H&M">
                <h3><?= $title ?></h3>
                <p><?= $author ?></p>
            </div>
            <div class="lux_history_container">
                <div class="lux_history_left_container">
                    <p><?= $descriptionParts[0] ?></p>
                    <div class="lux_history_left_img_container">
                        <?php foreach (array_slice($imagesParts, 0, 2) as $part) : ?>
                            <img src="<?= $part ?>" alt="">
                        <?php endforeach ?>
                    </div>
                </div>
                <img src="<?= $imagesParts[2] ?>" alt="" class="lux_history_right_img">
            </div>
            <div class="lux_three_container">
                <p><?= $descriptionParts[1] ?></p>
                <?php foreach (array_slice($imagesParts, 3, 2) as $part) : ?>
                    <img src="<?= $part ?>" alt="">
                <?php endforeach ?>
            </div>
            <div class="lux_last_container">
                <a href="/articles/luxury_mass_market" class="link_for_button">
                    <button class="hover_button_white_black">Открыть статью</button>
                </a>
                <img src="<?= $imagesParts[5] ?>" alt="">
            </div>
        </div>
    </div>
    <div class="sec_lux">
        <div class="sec_lux_first_container" id="Supreme">
            <div class="sec_lux_first_text_container">
                <?php foreach (array_slice($descriptionParts, 2, 3) as $key => $part) : ?>
                    <p class="sec_lux_first_text" <?php if ($key === 2) echo 'id="Balenciaga"' ?>><?= $part ?></p>
                <?php endforeach ?>
            </div>
            <div class="swiper swiper_right">
                <div class="swiper-wrapper">
                    <?php foreach (array_slice($imagesParts, 6, 5) as $part) : ?>
                        <div class="swiper-slide post">
                            <img src="<?= $part ?>" alt="" class="post-img">
                        </div>
                    <?php endforeach ?>
                </div>
                <div class="swiper-scrollbar"></div>
            </div>
        </div>
        <div class="sec_lux_second_container">
            <div class="swiper swiper_left">
                <div class="swiper-wrapper">
                    <?php foreach (array_slice($imagesParts, 11, 4) as $part) : ?>
                        <div class="swiper-slide post">
                            <img src="<?= $part ?>" alt="" class="post-img">
                        </div>
                    <?php endforeach ?>
                </div>
                <div class="swiper-scrollbar"></div>
            </div>
            <div class="sec_lux_second_text_container">
                <?php foreach (array_slice($descriptionParts, 5, 2) as $part) : ?>
                    <p class="sec_lux_second_text"><?= $part ?></p>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    <div class="width_container_beige">
        <div class="fashion_and_pop">
            <?php extract(FindById($link, 5)); ?>
            <h3><?= $title ?></h3>
            <div class="fashion_and_pop_container">
                <div class="fashion_and_pop_left_container">
                    <div class="fashion_and_pop_left_text_container" id="Moschino">
                        <?php foreach (array_slice($descriptionParts, 0, 2) as $part) : ?>
                            <p class="fashion_and_pop_left_text"><?= $part ?></p>
                        <?php endforeach ?>
                    </div>
                    <div class="fashion_and_pop_img_container">
                        <?php foreach (array_slice($imagesParts, 0, 2) as $part) : ?>
                            <img src="<?= $part ?>" alt="">
                        <?php endforeach ?>
                        <img src="<?= $imagesParts[3] ?>" alt="" class="fashion_and_pop_img_min_size">
                    </div>
                </div>
                <div class="fashion_and_pop_right_container">
                    <div class="fashion_and_pop_img_container second">
                        <?php foreach (array_slice($imagesParts, 2, 2) as $part) : ?>
                            <img src="<?= $part ?>" alt="">
                        <?php endforeach ?>
                    </div>
                    <div class="fashion_and_pop_right_text_container" id="Balmain">
                        <p class="fashion_and_pop_right_text"><?= $descriptionParts[2] ?></p>
                    </div>
                    <a href="/articles/pop_culture_fashion" class="link_for_button">
                        <button class="hover_button_black_orange">Открыть статью</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>