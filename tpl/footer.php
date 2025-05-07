<footer>
    <div class="footer_container">
        <div class="footer_grid">
            <div class="footer_info_container">
                <p class="footer_text">Мода — это искусство, тренды и эксперименты. Коллаборации стали её неотъемлемой частью, соединяя творчество и коммерцию, а их влияние на индустрию только растёт.</p>
                <div class="footer_icons"><?= ShowSvgIcons() ?></div>
            </div>
            <div class="footer_pages">
                <?= PagesLinks($link) ?>
            </div>
            <?php
            $brands = ['Supreme', 'Balmain', 'Moschino', 'Louis Vuitton', 'H&M', 'Dior', 'Chanel', 'Balenciaga'];
            $brandGroups = array_chunk($brands, 4);
            foreach ($brandGroups as $group): ?>
                <div class="footer_brands">
                    <?php foreach ($group as $brand): ?>
                        <p><?= $brand ?></p>
                    <?php endforeach ?>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</footer>
</body>
</html>