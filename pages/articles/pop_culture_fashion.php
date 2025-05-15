<section class="pop_culture">
    <?php extract(FindArticles($link, 3)); ?>
    <div class="pop_culture_container">
        <h3><?= $name ?></h3>
        <div class="pop_culture_header_container">
            <div class="pop_culture_header_left_container">
                <div class="pop_culture_header_left_text_container">
                    <?php foreach (array_slice($descriptionParts, 0, 2) as $part) : ?>
                        <p><?= $part ?></p>
                    <?php endforeach ?>
                </div>
                <img src="<?= $imagesParts[0] ?>" alt="">
            </div>
            <img src="<?= $imagesParts[1] ?>" alt="" class="pop_culture_header_right_img">
        </div>
        <div class="pop_culture_thirteenth_container">
            <div class="pop_culture_thirteenth_left_container">
                <p><?= $descriptionParts[2] ?></p>
                <div class="pop_culture_thirteenth_left_img_container">
                    <?php foreach (array_slice($imagesParts, 2, 2) as $part) : ?>
                        <img src="<?= $part ?>" alt="">
                    <?php endforeach ?>
                </div>
            </div>
            <img src="<?= $imagesParts[4] ?>" alt="" class="pop_culture_thirteenth_right_img">
        </div>
        <div class="pop_culture_simpson_container">
            <img src="<?= $imagesParts[5] ?>" alt="" class="pop_culture_simpson_img">
            <div class="pop_culture_simpson_right_container">
                <p><?= $descriptionParts[3] ?></p>
                <div class="pop_culture_simpson_right_img_container">
                    <img src="<?= $imagesParts[6] ?>" alt="">
                </div>
            </div>
        </div>
        <div class="pop_culture_balmain_container">
            <div class="pop_culture_balmain_left_container">
                <p><?= $descriptionParts[4] ?></p>
                <img src="<?= $imagesParts[7] ?>" alt="">
            </div>
            <div class="pop_culture_balmain_right_container">
                <?php foreach (array_slice($imagesParts, 8, 2) as $part) : ?>
                    <img src="<?= $part ?>" alt="">
                <?php endforeach ?>
            </div>
        </div>
        <div class="pop_culture_last_container">
            <?php foreach (array_slice($imagesParts, 10, 2) as $part) : ?>
                <img src="<?= $part ?>" alt="">
            <?php endforeach ?>
            <p><?= $descriptionParts[5] ?></p>
        </div>
    </div>
</section>