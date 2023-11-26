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
    <nav>
        <ul>
            <li><a href="<?= ROOT ?>">Home</a></li>
            <?php if (Auth::isLoggedIn()): ?>
            <li><a href="<?= ROOT ?>/admin/index.php">Admin</a> </li>
            <li><a href="<?= ROOT ?>/logout.php">Log out</a> </li>
            <?php else: ?>
            <li><a href="<?= ROOT ?>/login.php">Login</a> </li>
            <?php endif; ?>
        </ul>
    </nav>
        <main>