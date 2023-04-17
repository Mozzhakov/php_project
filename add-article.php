<?php

require './includes/init.php';
$conn = require './includes/db.php';

if (!Auth::isLoggedIn()) {
    die('Unauthorized');
}

$article = new Article();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $article->title = $_POST['title'];
    $article->content = $_POST['content'];
    $article->published_at = $_POST['published_at'];

    if ($article->addArticle($conn)) {
        Url::redirect("/php_project/article.php?id={$article->id}");
    }
}
require './includes/article-form.php';
require './includes/footer.php';
