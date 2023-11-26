<?php

require 'includes/init.php';

require 'includes/header.php';
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $conn = require 'includes/db.php';
    if(User::authenticate($conn,$_POST['username'],$_POST['password'])){
        //prevent session fixation attacks
        Auth::login();
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
    <br>
    <label for="password">Password</label>
    <input type="password" name="password" id="password">
    <br>
    <button>Log in</button>
</form>

<?php require 'includes/footer.php';?>