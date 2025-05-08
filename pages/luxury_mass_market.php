<section class="lux_market">
    <?php extract(FindArticles($link, 2)); ?>
    <div class="lux_market_container">
        <h3><?= $name ?></h3>
        <div class="lux_market_header_container">
            <div class="lux_market_header_left_container">
                <p><?= $descriptionParts[0] ?></p>
                <img src="<?= $imagesParts[0] ?>" alt="">
            </div>
            <img src="<?= $imagesParts[1] ?>" alt="">
        </div>
        <div class="lux_market_seventh_container">
            <div class="lux_market_seventh_left_container">
                <p><?= $descriptionParts[1] ?></p>
                <img src="<?= $imagesParts[3] ?>" alt="">
            </div>
            <img src="<?= $imagesParts[2] ?>" alt="">
        </div>
        <div class="lux_market_tenth_container">
            <img src="<?= $imagesParts[4] ?>" alt="">
            <div class="lux_market_tenth_right_container">
                <p><?= $descriptionParts[2] ?></p>
                <div class="lux_market_tenth_img_container">
                    <img src="<?= $imagesParts[5] ?>" alt="">
                </div>
            </div>
        </div>
        <div class="lux_market_thirteenth_container">
            <div class="lux_market_thirteenth_left_container">
                <p><?= $descriptionParts[3] ?></p>
                <img src="<?= $imagesParts[6] ?>" alt="">
            </div>
            <img src="<?= $imagesParts[7] ?>" alt="">
        </div>
        <div class="lux_market_fifteenth_container">
            <p><?= $descriptionParts[4] ?></p>
            <img src="<?= $imagesParts[8] ?>" alt="">
        </div>
        <div class="lux_market_last_container">
            <img src="<?= $imagesParts[10] ?>" alt="">
            <div class="lux_market_last_right_container">
                <p><?= $descriptionParts[5] ?></p>
                <div class="lux_market_last_img_container">
                    <img src="<?= $imagesParts[9] ?>" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
