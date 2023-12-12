<?php
require '../includes/init.php';


Auth::requireLogin();

//we initiate the values for the form fields with empty strings,
// so we can use it in the form, for values

$article = new Article();

$conn = require '../includes/db.php';

$categories_id = [];
$categories = Category::getAll($conn);

if ($_SERVER['REQUEST_METHOD'] == "POST"){


    $article->title = $_POST['title'];
    $article->content=$_POST['content'];
    $article->published_at = $_POST['published_at'];

    $categories_id = $_POST['category'] ?? [];

    if($article->create($conn)) {
        $article->setCategories($conn,$categories_id);
        header("Location: article.php?id={$article->id}");
    }

}

?>

<?php
 require '../includes/header.php';

 ?>

<h2>New article</h2>

<?php require "includes/article-form.php" ?>

<?php require '../includes/footer.php';