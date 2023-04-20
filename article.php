<?php
require './includes/header.php';
require './includes/init.php';
require './includes/modify-date.php';
$conn = require('./includes/db.php');

if (isset($_GET['id'])) {
    $article = Article::getArticleWithCategories($conn, $_GET['id']);
} else {
    $article = null;
}
// var_dump($article);
?>

<?php if ($article) : ?>
<h2><?= htmlspecialchars($article[0]['title']) ?></h2>
<p><?= htmlspecialchars($article[0]['content']) ?></p>
<time datetime="<?= $article[0]['published_at'] ?>">
    <?php modify($article[0]['published_at']) ?>
</time>
<?php if ($article[0]['category_name']) : ?>
<p>Categories:</p>
<ul>
    <?php foreach ($article as $el) : ?>
    <li><?= $el['category_name'] ?></li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>

<?php if (Auth::isLoggedIn()) : ?>
<a href="/php_project/edit-article.php?id=<?= $article[0]['id']; ?>">Edit</a>
<a href="/php_project/delete-article.php?id=<?= $article[0]['id']; ?>" id="deleteBtn">Delete</a>
<!-- <a href="/php_project/edit-image.php">Image</a> -->
<?php endif; ?>
<?php else : ?>
<p>Article not found</p>
<?php endif; ?>
<?php require './includes/footer.php'; ?>