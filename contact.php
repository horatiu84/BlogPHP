<?php require 'includes/init.php'?>

<?php require 'includes/header.php'; ?>

<h2>Contact</h2>

<form method="post" >
    <div class="form-group">
        <label for="email">Your email</label>
        <input class="form-control" id="email" name="email" type="email" placeholder="Your email">
    </div>

    <div class="form-group">
        <label for="subject">Subject</label>
        <input class="form-control" id="subject" name="subject" type="text" placeholder="Subject">
    </div>

    <div class="form-group">
        <label for="message">Message</label>
        <textarea  class="form-control" id="message" name="message"  placeholder="Your message"></textarea>
    </div>

    <button class="btn">Send</button>
</form>

<?php require 'includes/footer.php'; ?>