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

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $errorIndex = $_FILES["file"]["error"];

    try {
        if (empty($_FILES)) {
            throw new Exception('Invalid upload');
        }
        switch ($errorIndex) {
            case 0:
                break;
            case 1:
                throw new Exception('File is too large(from the server settimgs)');
                break;
            default:
                throw new Exception('We have a error. Try Again');
                break;
        }

        if ($_FILES["file"]["size"] > 2000000) {
            throw new Exception('File is too large');
        }

        $allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];
        if (!in_array($_FILES['file']['type'], $allowedFileTypes)) {
            throw new Exception('Invalid file type');
        }

        // $destinition = '/uploads' . $_FILES['file']['name'];
        // if (move_uploaded_file($_FILES['file']['tmp_name'], $destinition)) {
        //     echo "Successfully moved";
        // }
        
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    var_dump($_FILES);
}

require './includes/header.php'; ?>

<h1>Edit article image</h1>

<form method="POST" enctype="multipart/form-data">
    <div>
        <label for="file">Image file</label>
        <input type="file" name="file" id="file">
    </div>
    <button>Submit</button>
</form>

<?php
require './includes/footer.php'; ?>