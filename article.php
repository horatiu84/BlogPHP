<?php

$db_host = 'localhost';
$db_name = 'test';
$db_user = 'root';
$db_pass = '';

$conn = mysqli_connect($db_host,$db_user,$db_pass,$db_name);

$sql = "SELECT * 
        FROM articole
        WHERE id=0";


$results = mysqli_query($conn,$sql);

if ($results === false) {
    echo  mysqli_error($conn);
} else {
    $article = mysqli_fetch_assoc($results);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My blog</title>
    <meta charset="utf-8">
</head>
<body>
<header>
    <h1>My blog</h1>
</header>
<main>
    <?php if ($article === null): ?>
        <p>Article not found!</p>
    <?php else: ?>

                    <article>
                        <h2><?= $article['title'] ?></h2>
                        <p><?= $article['content'] ?></p>
                    </article>
    <?php endif; ?>
</main>
</body>
</html>
