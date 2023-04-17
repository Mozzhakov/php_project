<?php
require './includes/header.php';
// require './classes/Article.php';
require './includes/init.php';

$conn = require('./includes/db.php');

$articles = Article::getAll($conn);
?>
<?php if (empty($articles)) : ?>
    <p>No articles found</p>
<?php else : ?>
    <ul>
        <?php foreach ($articles as $article) : ?>
            <li>
                <article>
                    <h2><a href="/php_project/article.php?id=<?= $article['id'] ?>"><?= $article['title']; ?></a></h2>
                </article>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif;
require './includes/footer.php';
?>