<?php
require "includes/database.php";
require 'includes/article.php';
$conn = getDb();

if (isset($_GET['id'])) {

    $article = getArticle($conn,$_GET['id']);

    if ($article) {
        $id=$article['id'];
        $title = $article['title'];
        $content = $article['content'];
        $published_at = $article['published_at'];
    } else {
        die("article not found");
    }

} else {
    die("id not supplied, article not found");
}
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $title = $_POST['title'] ;
    $content = $_POST['content'] ;
    $published_at = $_POST['published_at'];

    $errors = validateArticle($title,$content);

    if(empty($errors)) {

        //1. write sql statement that contains placeholders:
        $sql = "UPDATE articole 
                SET title = ?,
                    content =? ,
                    published_at = ?
                WHERE id =?";
        //2. We prepare the statement:
        $stmt = mysqli_prepare($conn, $sql);

        if($published_at == '') {
            $published_at = null;
        }

        //3. Bind data to the placeholders
        mysqli_stmt_bind_param($stmt, "sssi", $title, $content, $published_at,$id);
        //3. Execute the statement :
        if (mysqli_stmt_execute($stmt)) {

            header("Location: article.php?id=$id");
            exit;
        } else {
            echo 'Something is wrong';
        }
    }
}


?>

<?php
require 'includes/header.php';

?>

    <h2>Edit article</h2>

<?php require "includes/article-form.php" ?>

<?php require 'includes/footer.php';
