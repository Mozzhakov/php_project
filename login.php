<!-- 
1. метод пост?
2. подкл коннект
3. если метод класса аус излоггдин с данными - тру, то
4. регенерация айди
5. сессия излоггдин - тру
6. редирект на главную
7. если не тру, то вронг креденшиалс -->
<?php

require './includes/init.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = require './includes/db.php';

    if (User::authenticate($conn, $_POST['username'], $_POST['password'])) {
        session_regenerate_id(true);
        $_SESSION['is_logged_in'] = true;
        header("Location: /php_project/");
        Url::redirect('/php_project/');
    } else {
        $error = "Wrong credentials";
    }
}
?>

<?php require './includes/header.php'; ?>

<?php if (!empty($error)) : ?>
    <p><?= $error ?></p>
<?php endif; ?>
<form method="POST">
    <div>
        <label for="username">Username</label>
        <input type="text" id="username" name="username">
    </div>
    <div>
        <label for="password">Password</label>
        <input type="text" id="password" name="password">
    </div>
    <button type="submit">Log in</button>
</form>

<?php require './includes/footer.php'; ?>