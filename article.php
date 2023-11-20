<?php
require "includes/database.php";
require 'includes/article.php';
$conn = getDb();

if (isset($_GET['id'])) {

//    $sql = "SELECT *
//        FROM articole
//        WHERE id=" .$_GET['id'];
//
//
//    $results = mysqli_query($conn,$sql);
//
//    if ($results === false) {
//        echo  mysqli_error($conn);
//    } else {
//        $article = mysqli_fetch_assoc($results);
//    }
    $article = getArticle($conn,$_GET['id'],'id');
} else {
    $article = null;
}


?>
<?php require_once('includes/header.php'); ?>
<main>
    <?php if ($article === null): ?>
        <p>Article not found!</p>
    <?php else: ?>

                    <article>
                        <h2><?= htmlspecialchars($article['title']) ?></h2>
                        <p><?= htmlspecialchars($article['content']) ?></p>
                        <a href="edit-article.php?id=<?=$article['id']?>">Edit</a>
                        <a href="delete-article.php?id=<?=$article['id']?>">Delete</a>

                    </article>
    <?php endif; ?>

<?php include_once('includes/footer.php');?>