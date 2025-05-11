<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/tpl/_head.php' ?>
<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) die("Ошибка безопасности!");

    $email = trim($_POST['email'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $errors = [];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Некорректный email";

    if (strlen($username) <= 2) $errors[] = "Логин должен содержать от 2 символов";

    if (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) $errors[] = "Пароль должен содержать минимум 8 символов, латинаские буквы и цифры";

    if (empty($errors)) {
        $userId = RegisterUser($link, $email, $username, $password);
        if ($userId) {
            $_SESSION['registration_success'] = true;
            header("Location: /");
            $_SESSION['user'] = ['id' => $userId, 'email' => $email, 'username' => $username];
            exit;
        } else {
            $errors[] = "Логин или email уже существует";
        }
    }

    $_SESSION['registration_errors'] = $errors;
    header("Location: /registration");
    exit;
}
?>
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
            <form class="registration_fields" name="registration" method="post">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="register" value="1">
                <div class="registration_fields_inp">
                    <input type="text" name="username" placeholder="Логин" class="registration_input"
                           value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
                    <input type="email" name="email" placeholder="Email" class="registration_input"
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                    <input type="password" name="password" placeholder="Пароль" class="registration_input" required>
                </div>
                <?php if (!empty($_SESSION['registration_errors'])): ?>
                    <div class="auth_error_message_container">
                        <div class="auth_error_message">
                            <?php foreach ($_SESSION['registration_errors'] as $error): ?>
                                <p class="auth_error small"><?= htmlspecialchars($error) ?></p>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php unset($_SESSION['registration_errors']) ?>
                <?php endif; ?>
                <div class="registration_fields_btn">
                    <button class="hover_button_black_orange" type="submit">
                        Зарегистрироваться
                    </button>
                    <a href="/authorisation" class="registration_link_to_auth">У вас уже есть аккаунт? Нажмите здесь,
                        чтобы войти.</a>
                </div>
            </form>
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
