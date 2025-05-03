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
</section>