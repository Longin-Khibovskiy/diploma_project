<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tpl/_head.php' ?>
<?php
session_start();

if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) die("Ошибка безопасности!");

    $loginOrEmail = trim($_POST['login_or_email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $loginResult = LoginUser($link, $loginOrEmail, $password);

    if ($loginResult === 'success') {
        header("Location: /");
        exit;
    } else {
        if ($loginResult === 'user_not_found') {
            $_SESSION['auth_error'] = "Неверный логин или почта";
        } elseif ($loginResult === 'invalid_password') {
            $_SESSION['auth_error'] = "Неверный пароль";
        } else {
            $_SESSION['auth_error'] = "Ошибка авторизации";
        }
        header("Location: /user/authorisation");
        exit;
    }
}
?>
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
            <form class="authorisation_fields" method="post">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="login" value="1">
                <div class="authorisation_fields_inp">
                    <input type="text" name="login_or_email" placeholder="Логин или почта" class="authorisation_input"
                           value="<?= htmlspecialchars($_POST['login_or_email'] ?? '') ?>" required>
                    <input type="password" name="password" placeholder="Пароль" class="authorisation_input"
                           minlength="8" required>
                </div>
                <?php if (!empty($_SESSION['auth_error'])): ?>
                    <div class="auth_error_message_container">
                        <div class="auth_error_message">
                            <p class="auth_error small"><?= htmlspecialchars($_SESSION['auth_error']); ?></p>
                        </div>
                    </div>
                    <?php unset($_SESSION['auth_error']) ?>
                <?php endif; ?>
                <div class="authorisation_fields_btn">
                    <button class="hover_button_black_orange" type="submit">Войти</button>
                    <button class="hover_button_white_black" onclick="location.href='/user/registration';">
                        Зарегистрироваться
                    </button>
                </div>
            </form>
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