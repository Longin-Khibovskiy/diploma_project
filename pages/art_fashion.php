<section class="art_and_fashion">
    <?php extract(FindArticles($link, 1)); ?>
    <div class="art_and_fashion_container">
        <div class="art_and_fashion_header_container">
            <h3><?= $name ?></h3>
            <p class="art_and_fashion_header_text"><?= $descriptionParts[0] ?></p>
            <div class="art_and_fashion_header_img_container">
                <?php foreach (array_slice($imagesParts, 0, 2) as $part) : ?>
                    <img src="<?= $part ?>" alt="">
                <?php endforeach ?>
            </div>
        </div>
        <div class="art_and_fashion_first_work_container">
            <p><?= $descriptionParts[1] ?></p>
            <div class="swiper swiper_right">
                <div class="swiper-wrapper">
                    <?php foreach (array_slice($imagesParts, 2, 3) as $part) : ?>
                        <div class="swiper-slide post">
                            <img src="<?= $part ?>" alt="" class="post-img">
                        </div>
                    <?php endforeach ?>
                </div>
                <div class="swiper-scrollbar"></div>
            </div>
        </div>
    </div>
</section>