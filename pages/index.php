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
                    <h1 class="page_title"><?php echo $firstWord ?></h1>
                    <div class="author_container">
                        <p class="author_page">«от Сальвадора Дали и Schiaparelli до H&M и Mugler»</p>
                    </div>
                    <div class="second_paragraph">
                        <h2 class="page_title"><?php echo $otherText ?></h2>
                    </div>
                </div>
        <?php
        endif;
    endif;
?>
    <div class="home_video">
        <img src="../images/video.png" alt="">
    </div>
    <p class="first_description_home_page">Модных тандемов сегодня настолько много, что пора заводить на них уже отдельный толковый словарь. Тиффани и Суприм, Суприм и Луи Виттон, Луи Виттон и Найк, Найк и Диор, Диор и Биркеншток. А Биркеншток ещё с десятком других люксовых гигантов. Перечислять кто, с кем, когда и зачем можно до Луны и обратно.</p>
    <div class="description_home_page_container">
        <p class="second_description_home_page">Давайте вспомним самые громкие кейсы и в конце концов поймём, как же все это произошло и как стало главным событием в индустрии.</p>
    </div>
    <div class="whats_collaboration">
        <?php
        $sql = "SELECT * FROM HomeArticles WHERE id = 1";
        $result = $link->query($sql);
        if ($result && $result->num_rows > 0) :
            $row = $result->fetch_assoc();
            $title = $row['title'];
            $description = $row['description'];
            $images = $row['images'];
            $descriptionParts = array_filter(explode('/', $description));
            $descriptionParts = array_map('trim', $descriptionParts);
            $imagesParts = array_map('trim', array_filter(explode(',', $images)));
            ?>
            <h3><?php echo $title ?></h3>
            <div class="whats_container">
                <div class="whats_left">
                    <p class="whats_first_text"><?php echo $descriptionParts[0] ?></p>
                    <?php foreach (array_slice($descriptionParts, 1, 2) as $part) :?>
                        <p class="whats_other_text"><?php echo $part ?></p>
                    <?php endforeach ?>
                    <img src="<?php echo $imagesParts[0] ?>" alt="" class="whats_left_img">
                </div>
                <div class="whats_right">
                    <img src="<?php echo $imagesParts[1] ?>" alt="" class="whats_first_right_img">
                    <p class="whats_right_text"><?php echo $descriptionParts[3] ?></p>
                    <div class="whats_imgs_container">
                        <?php foreach (array_slice($imagesParts, 2, 2) as $part) :?>
                            <img src="<?php echo $part ?>" alt="" class="whats_right_img">
                        <?php endforeach ?>
                        <div class="whats_amazing_img">
                            <img src="<?php echo $imagesParts[4] ?>" alt="">
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
    </div>
</section>