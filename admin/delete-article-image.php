<?php
require '../includes/init.php';

Auth::requireLogin();
$conn = require '../includes/db.php';

if (isset($_GET['id'])) {

    $article = Article::getById($conn,$_GET['id']);

    if (!$article) {
        die("article not found");
    }
} else {
    die("id not supplied, article not found");
}
if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $previpus_image = $article->image_file;

            if ( $article->setImageFile($conn,null) ) {
                if ($previpus_image) {
                    unlink("../uploads/$previpus_image");
                }
                header("Location: article.php?id={$article->id}");
            };
}

?>

<?php
require '../includes/header.php';

?>

    <h2>Delete article image</h2>

<?php if ($article->image_file) : ?>
    <img src="/uploads/<?=$article->image_file; ?>">

<?php endif; ?>

    <form method="post" >
        <p>Are you sure?</p>
        <button>Delete</button>
        <a href="edit-article-img.php?id=<?= $article->id ?>">Cancel</a>
    </form>

<?php require "../includes/footer.php";
