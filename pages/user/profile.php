<section class="profile">
    <div class="profile_container">
        <h3>Аккаунт</h3>
        <p>Вы вошли как <?= htmlspecialchars($_SESSION['user']['username']) ?></p>
        <div class="profile_data">
            <p class="medium profile_data_title">Учетные данные</p>
            <div class="profile_data_email_container">
                <p class="small">Email</p>
                <p><?= htmlspecialchars($_SESSION['user']['email']) ?></p>
            </div>
            <hr>
            <div class="profile_data_password_container">
                <p class="small">Пароль</p>
                <p class="profile_forgot_password"><a href="../../index.php">Сменить пароль</a></p>
            </div>
        </div>
    </div>
</section>