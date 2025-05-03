<section class="home">
<?php
    $pageName = "Главная";
    $sql = "SELECT description FROM Pages WHERE name = '$pageName'";
    $result = $link->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $description = $row['description'];
        $words = explode(" ", $description);
        if (count($words) > 0) {
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
        }
    }
?>
</section>