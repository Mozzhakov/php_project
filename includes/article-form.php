<?php if (!empty($article->errors)) : ?>
<ul>
    <?php foreach ($article->errors as $error) : ?>
    <li><?= $error ?></li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>


<form method="POST">
    <div>
        <label for="">Title</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($article->title ?? '') ?>">
    </div>
    <div>
        <label for="">Content</label>
        <textarea type="text" id="content" name="content"><?= htmlspecialchars($article->content ?? '') ?></textarea>
    </div>
    <div>
        <label for="">Publication date</label>
        <input type="datetime-local" id="published_at" name="published_at"
            value="<?= htmlspecialchars($article->published_at ?? '') ?>">
    </div>
    <fieldset>
        <legend>Categories</legend>
        <?php foreach ($categories as $category) : ?>
        <div><input type="checkbox" name="category[]" id="category<?= $category['id'] ?>" value="<?= $category['id'] ?>"
                <?php if (in_array($category['id'], $categories_ids)) : ?> checked <?php endif; ?>><label
                for="category<?= $category['id'] ?>"><?= $category['name'] ?></label></div>
        <?php endforeach; ?>
    </fieldset>
    <button>Save</button>
</form>