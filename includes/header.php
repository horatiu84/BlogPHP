<!DOCTYPE html>
<html lang="en">
    <head>
        <title>My blog</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
        <div class="container">
        <header>
            <h1>My blog</h1>
        </header>
        <nav>
            <ul class="nav">
                <li class="nav-item"><a class="nav-link" href="<?= ROOT ?>">Home</a></li>
                <?php if (Auth::isLoggedIn()): ?>
                <li class="nav-item"><a class="nav-link" href="<?= ROOT ?>/admin/index.php">Admin</a> </li>
                <li class="nav-item"><a class="nav-link" href="<?= ROOT ?>/logout.php">Log out</a> </li>
                <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="<?= ROOT ?>/login.php">Login</a> </li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link" href="<?= ROOT ?>/contact.php">Contact</a></li>
            </ul>
        </nav>
            <main>