<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tpl/_head.php' ?>
<?php extract(FindArticles($link, 5)); ?>
<section class="registration">
    <div class="registration_container">
        <a href="/" class="back_to_home_link">
            <svg width="15" height="26" viewBox="0 0 15 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15 1.87629L3.78378 13L15 24.1237L13.1081 26L0 13L13.1081 4.5423e-07L15 1.87629Z"
                      fill="#F3F3F3"/>
            </svg>
            Вернуться на главную
        </a>
        <img src="<?= $imagesParts[0] ?>" alt="" class="registration_main_img">
        <div class="registration_main_container">
            <h4><?= $name ?></h4>
            <p class="registration_policy"><?= $descriptionParts[0] ?></p>
            <div class="registration_fields">
                <div class="registration_fields_inp">
                    <input type="text" placeholder="Логин" class="registration_input">
                    <input type="email" placeholder="Email" class="registration_input">
                    <input type="password" minlength="8" placeholder="Пароль" class="registration_input">
                </div>
                <div class="registration_fields_btn">
                    <button class="hover_button_black_orange" onclick="location.href='/registration';">
                        Зарегистрироваться
                    </button>
                    <a href="/authorisation" class="registration_link_to_auth">У вас уже есть аккаунт? Нажмите здесь,
                        чтобы войти.</a>
                </div>
            </div>
            <div class="registration_separation_container">
                <hr>
                <p class="small">Авторизоваться через</p>
                <hr>
            </div>
            <div class="registration_social_container">
                <button class="registration_button" onclick="location.href='/auth_with_google';">
                    <img src="/images/registration/google.svg" alt="">
                    <span>Авторизоваться через Google</span>
                </button>
                <button class="registration_button">
                    <img src="/images/registration/x.svg" alt="" class="registration_button_x_img">
                    <span>Авторизоваться через X</span>
                </button>
            </div>
        </div>
    </div>
</section>
