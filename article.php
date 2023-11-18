<?php
require "includes/database.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $conn = getDb();
    $sql = "SELECT * 
        FROM articole
        WHERE id=" .$_GET['id'];


    $results = mysqli_query($conn,$sql);

    if ($results === false) {
        echo  mysqli_error($conn);
    } else {
        $article = mysqli_fetch_assoc($results);
    }
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
                    </article>
    <?php endif; ?>

<?php include_once('includes/footer.php');?>