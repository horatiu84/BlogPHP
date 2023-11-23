
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
    <div>
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" value="<?= htmlspecialchars($article->title) ?>">
    </div>
    <div>
        <label for="content">Content</label>
        <textarea name="content" placeholder="Article content" id="content"><?= htmlspecialchars($article->content) ?></textarea>
    </div>
    <div>
        <label for="published_at">Publication date and time</label>
        <input type="datetime-local" name="published_at" id="published_at" value="<?= htmlspecialchars($article->published_at) ?>">
    </div>

    <button>Save</button>

</form>

<?php require 'includes/footer.php';