<?php
require './includes/init.php';
require './includes/modify-date.php';
if (Auth::isLoggedIn()) :
    $conn = require './includes/db.php';
    $article = Article::getArticleByID($conn, $_POST['id']);
    $published_at = $article->publish($conn);
    Url::redirect("/php_project/"); ?>
<time><?= modify($published_at) ?></time>

<?php else : ?>
<p>Unauthorized</p>
<?php endif; ?>