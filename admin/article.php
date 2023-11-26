<?php
require '../includes/init.php';
Auth::requireLogin();
$conn = require '../includes/db.php';

if (isset($_GET['id'])) {

    $article = Article::getById($conn,$_GET['id']);
} else {
    $article = null;
}


?>
<?php require_once('../includes/header.php'); ?>
<main>
    <?php if ($article ): ?>
    <article>
        <h2><?= htmlspecialchars($article->title) ?></h2>
        <p><?= htmlspecialchars($article->content) ?></p>
        <a href="edit-article.php?id=<?=$article->id?>">Edit</a>
        <a href="delete-article.php?id=<?=$article->id?>">Delete</a>
    </article>
    <?php else: ?>
    <p>Article not found!</p>

    <?php endif; ?>

<?php include_once('../includes/footer.php');?>