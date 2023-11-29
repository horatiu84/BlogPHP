<?php

require 'includes/init.php';

$conn = require 'includes/db.php';


//if (isset($_GET['page'])) {
//    $paginator = new Paginator($_GET['page'],4);
//} else {
//    $paginator = new Paginator(1,4);
//}
$paginator = new Paginator($_GET['page'] ?? 1,4,Article::getTotal($conn));

$articles = Article::getPage($conn,$paginator->limit,$paginator->offset);

?>

<?php require_once('includes/header.php'); ?>
       


        <?php if (empty($articles)): ?>
        <p>No articles found!</p>
        <?php else: ?>
        <ul>
            <?php foreach ($articles as $article): ?>
            <li>
                <article>
                    <h2><a href="article.php?id=<?= $article['id']?>" ><?= htmlspecialchars($article['title']) ?></a></h2>
                    <p><?= htmlspecialchars($article['content']) ?></p>
                </article>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php require 'includes/pagination.php' ;?>
        <?php endif; ?>
 <?php include_once('includes/footer.php');?>
