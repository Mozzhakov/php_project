<form method="post">
    <div>
        <label for="">Title</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($article->title && '') ?>">
    </div>
    <div>
        <label for="">Content</label>
        <textarea type="text" id="content" name="content"><?= htmlspecialchars($article->content && '') ?></textarea>
    </div>
    <div>
        <label for="">Publication date</label>
        <input type="text" id="published_at" name="published_at" value="<?= htmlspecialchars($article->published_at && '') ?>">
    </div>
    <button>Save</button>
</form>