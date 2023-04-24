<?php

require './includes/init.php';
$conn = require './includes/db.php';

if (!Auth::isLoggedIn()) {
    die('Unauthorized');
}

$article = new Article();

$categories = Category::getAll($conn);
$categories_ids = array_column($article->getCategories($conn), 'id');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $article->title = $_POST['title'];
    $article->content = $_POST['content'];
    $article->published_at = $_POST['published_at'];
    $categories_ids = $_POST['category'];

    if ($article->addArticle($conn)) {
        $article->setCategories($conn, $categories_ids);
        Url::redirect("/php_project/article.php?id={$article->id}");
    }
}
require './includes/article-form.php';
require './includes/footer.php';