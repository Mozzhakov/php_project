<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
</head>

<body>
    <?php require './includes/init.php'; ?>
    <header>
        <a href="/php_project/">My Blog</a>
        <?php if (Auth::isLoggedIn()) : ?>
            <a href="/php_project/add-article.php">New article</a>
            <a href="/php_project/logout.php">Log out</a>

        <?php else : ?>
            <a href="/php_project/login.php">Log in</a>
        <?php endif; ?>
    </header>