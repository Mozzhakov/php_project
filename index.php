<?php
require './includes/init.php';
require './includes/modify-date.php';
$conn = require('./includes/db.php');

if (Auth::isLoggedIn()) {
    $articles = Article::getAll($conn);
} else {
    $articles = Article::getAllPublished($conn);
}

?>
<?php require './includes/header.php'; ?>
<?php if (!Auth::isLoggedIn()) : ?>
<h1>USE LOGIN "ivan" AND PASSWORD "1111" TO LOG IN</h1>
<?php endif; ?>
<h1>Articles</h1>
<?php if (empty($articles)) : ?>
<p>No articles found</p>
<?php else : ?>
<ul>
    <?php foreach ($articles as $article) : ?>
    <li>
        <article>
            <h2><a href="/php_project/article.php?id=<?= $article['id'] ?>"><?= $article['title']; ?></a></h2>
            <p><?= $article['content']; ?></p>
            <p><?php echo $article['published_at'] ? modify($article['published_at']) : "unpublished" ?></p>
            <?php if (!$article['published_at']) : ?>
            <button id="publishBtn" data-id="<?= $article['id'] ?>">Publish now</button>
            <?php endif; ?>
        </article>
    </li>
    <?php endforeach; ?>
</ul>
<?php endif;
require './includes/footer.php';
?>