<?php
require './includes/init.php';
require './includes/modify-date.php';
$conn = require('./includes/db.php');

if (Auth::isLoggedIn()) {
    $totalAmountOfArticles = count(Article::getAll($conn));
    $paginator = new Paginator($_GET['page'] ?? 1, 4, $totalAmountOfArticles);
    $articles = Article::getPageOfArticles($conn, $paginator->limit, $paginator->offset);
} else {
    $totalAmountOfPublishedArticles = count(Article::getAllPublished($conn));
    $paginator = new Paginator($_GET['page'] ?? 1, 4, $totalAmountOfPublishedArticles);
    $articles = Article::getPageOfPublishedArticles($conn, $paginator->limit, $paginator->offset);
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
<nav>
    <ul>
        <?php if ($paginator->previousPage !== 0) : ?>
        <li><a href="?page=<?= $paginator->previousPage ?>">Previous</a></li>
        <?php endif; ?>
        <?php if ((int)$paginator->totalPages + 1 !== $paginator->nextPage) : ?>
        <li><a href="?page=<?= $paginator->nextPage ?>">Next</a></li>
        <?php endif; ?>
    </ul>
</nav>
<?php endif;
require './includes/footer.php';
?>