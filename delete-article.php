<?php
require "includes/database.php";
require 'includes/article.php';
$conn = getDb();

if (isset($_GET['id'])) {

    $article = getArticle($conn,$_GET['id'],'id');

    if ($article) {
        $id=$article['id'];

    } else {
        die("article not found");
    }

} else {
    die("id not supplied, article not found");
}

if($_SERVER["REQUEST_METHOD"] === "POST") {


//1. write sql statement that contains placeholders:
    $sql = "DELETE FROM articole 
                WHERE id =?";
//2. We prepare the statement:
    $stmt = mysqli_prepare($conn, $sql);


//3. Bind data to the placeholders
    mysqli_stmt_bind_param($stmt, "i", $id);
//3. Execute the statement :
    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    } else {
        echo 'Something is wrong';
    }
}
?>

<?php require 'includes/header.php'; ?>
<h2>Delete article</h2>

    <p>Are you sure ?</p>
    <form method="post" >
        <button>Delete</button>
    </form>
    <a href="article.php?id=<?=$article['id']?>">Cancel</a>
<?php require  'includes/footer.php' ?>