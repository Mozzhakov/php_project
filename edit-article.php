<!-- 
    1. add autoload 
    2. add connection
    3. check if article exists
    4. check if method - post
    5. fill in all parametrs 
    6. if article update - then redirect to article page
 -->

<?php
require './includes/init.php';

$conn = require './includes/db.php';

if (isset($_GET['id'])) {
    $article = Article::getArticleByID($conn, $_GET['id']);
    if (!$article) {
        echo "Article not found";
    }
} else {
    echo "Please specify article id";
}

$categories = Category::getAll($conn);
$categories_ids = array_column($article->getCategories($conn), 'id');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $article->title = $_POST['title'];
    $article->content = $_POST['content'];
    $article->published_at = $_POST['published_at'];
    $categories_ids = $_POST['category'];

    if ($article->updateArticle($conn)) {
        $article->setCategories($conn, $categories_ids);
        Url::redirect("/php_project/article.php?id={$article->id}");
    }
}
require './includes/article-form.php';
require './includes/footer.php';