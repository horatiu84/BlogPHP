<?php

session_start();
require 'includes/header.php';
if($_SERVER['REQUEST_METHOD'] == "POST") {
    if($_POST['username'] === 'hora' && $_POST['password'] === 'secret'){
        $_SESSION['is_logged_in'] = true;
        header('Location: index.php');
    } else {
        $error = "Incorrect credentials";
    }
}



?>

<h2>Login</h2>
<?php if(! empty($error)) :?>
    <p><?= $error ?></p>
<?php endif; ?>
<form method="post">
    <label for="username">Username</label>
    <input name="username" id="username">
    <label for="password">Password</label>
    <input type="password" name="password" id="password">
    <button>Log in</button>
</form>

<?php require 'includes/footer.php';?>