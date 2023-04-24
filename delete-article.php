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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($article->deleteArticle($conn)) {
        Url::redirect('/php_project/');
    }
}
?>

<?php require './includes/header.php'; ?>

<form method="POST">
    <p>Are you sure?</p>
    <button>Yes</button>
    <a href="/php_project/delete-article.php?id=<?= $article->id; ?>"></a>
</form>
<?php require './includes/footer.php' ?>