
<?php if(!empty($article->errors)): ?>
    <div>
        <ul>
            <?php foreach ($article->errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="post">
    <div class="form-group">
        <label for="title">Title:</label>
        <input class="form-control" type="text" name="title" id="title" value="<?= htmlspecialchars($article->title) ?>">
    </div>
    <div class="form-group">
        <label for="content">Content</label>
        <textarea class="form-control" name="content" placeholder="Article content" id="content"><?= htmlspecialchars($article->content) ?></textarea>
    </div>
    <div class="form-group">
        <label for="published_at">Publication date and time</label>
        <input class="form-control" type="datetime-local" name="published_at" id="published_at" value="<?= htmlspecialchars($article->published_at) ?>">
    </div>

    <fieldset>
        <legend>Categories</legend>
        <?php foreach ($categories as $category) : ?>
            <div class="form-check">
                <input class="form-check-input"
                        type="checkbox"
                        name="category[]"
                        value="<?= $category['id'] ?>"
                        id="<?= $category['id'] ?>"
                            <?php if(in_array($category['id'],$categories_id)) : ?>
                                checked
                            <?php endif; ?>
                >
                <label class="form-check-label" for="<?= $category['id'] ?>"><?=htmlspecialchars($category['name']) ?></label>
            </div>
        <?php endforeach; ?>
    </fieldset>

    <button class="btn">Save</button>

</form>

