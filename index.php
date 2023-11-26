<?php

require 'includes/init.php';

$conn = require 'includes/db.php';

//$sql = "SELECT *
//        FROM articole
//        ORDER BY published_at";
//$results = $conn->query($sql);
//
//$articles = $results->fetchAll(PDO::FETCH_ASSOC);

$articles = Article::getAll($conn);

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
        <?php endif; ?>
 <?php include_once('includes/footer.php');?>
