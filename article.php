<?php
require './includes/header.php';
require './includes/init.php';
$conn = require('./includes/db.php');

if (isset($_GET['id'])) {
    $article = Article::getArticleByID($conn, $_GET['id']);
} else {
    $article = null;
}
?>

<?php if ($article) : ?>
    <h2><?= htmlspecialchars($article->title) ?></h2>
    <p><?= htmlspecialchars($article->content) ?></p>
    <?php if (Auth::isLoggedIn()) : ?>
        <a href="/php_project/edit-article.php?id=<?= $article->id; ?>">Edit</a>
        <a href="/php_project/delete-article.php?id=<?= $article->id; ?>">Delete</a>
        <!-- <a href="/php_project/edit-image.php">Image</a> -->
    <?php endif; ?>
<?php else : ?>
    <p>Article not found</p>
<?php endif; ?>