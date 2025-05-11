<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tpl/_head.php' ?>
<?php extract(FindArticles($link, 4)); ?>
<section class="authorisation">
    <div class="authorisation_container">
        <a href="/" class="back_to_home_link">
            <svg width="15" height="26" viewBox="0 0 15 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15 1.87629L3.78378 13L15 24.1237L13.1081 26L0 13L13.1081 4.5423e-07L15 1.87629Z"
                      fill="#F3F3F3"/>
            </svg>
            Вернуться на главную
        </a>
        <img src="<?= $imagesParts[0] ?>" alt="" class="authorisation_main_img">
        <div class="authorisation_main_container">
            <h4><?= $name ?></h4>
            <p class="authorisation_policy"><?= $descriptionParts[0] ?></p>
            <div class="authorisation_fields">
                <div class="authorisation_fields_inp">
                    <input type="email" placeholder="Email" class="authorisation_input">
                    <input type="password" minlength="8" placeholder="Пароль" class="authorisation_input">
                </div>
                <div class="authorisation_fields_btn">
                    <button class="hover_button_black_orange">Войти</button>
                    <button class="hover_button_white_black" onclick="location.href='/registration';">Зарегистрироваться</button>
                </div>
            </div>
            <div class="authorisation_separation_container">
                <hr>
                <p class="small">Авторизоваться через</p>
                <hr>
            </div>
            <div class="authorisation_social_container">
                <button class="authorisation_button" onclick="location.href='/auth_with_google';">
                    <img src="/images/authorisation/google.svg" alt="">
                    <span>Авторизоваться через Google</span>
                </button>
                <button class="authorisation_button">
                    <img src="/images/authorisation/x.svg" alt="" class="authorisation_button_x_img">
                    <span>Авторизоваться через X</span>
                </button>
            </div>
        </div>
    </div>
</section>