<?php
require 'classes/Database.php';
require 'classes/Article.php';
$db = new Database();
$conn = $db->getConn();

if (isset($_GET['id'])) {
    $article = Article::getById($conn,$_GET['id']);

    if (!$article) {
        die("Article not found");
    }

} else {
    die("id not supplied, article not found");
}

if($_SERVER["REQUEST_METHOD"] === "POST") {

    if($article->delete($conn)){
        header("Location: index.php");
        exit;
    }
}
?>

<?php require 'includes/header.php'; ?>
<h2>Delete article</h2>

    <p>Are you sure ?</p>
    <form method="post" >
        <button>Delete</button>
    </form>
    <a href="article.php?id=<?=$article->id?>">Cancel</a>
<?php require  'includes/footer.php' ?>