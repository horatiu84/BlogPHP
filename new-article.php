<?php
include_once 'includes/database.php';

$errors = [];
//we initiate the values for the form fields with empty strings,
// so we can use it in the form, for values
$title = '' ;
$content ='' ;
$published_at = '';

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // we can use the variable below, to take the values we typed in the form
    // so if there will be errors, the values for the correct field will remain in html
    $title = $_POST['title'] ;
    $content = $_POST['content'] ;
    $published_at = $_POST['published_at'];

    // we validate the form
    if ($title == '') {
        $errors[]="The title is required";
    }
    if ($content == '') {
        $errors[]="The content is required";
    }

    if(empty($errors)) {



        $conn = getDb();
// FIRST METHOD to avoid sql injections


//    $title = mysqli_real_escape_string($_POST['title']) ;
//    $content = mysqli_real_escape_string($_POST['content']) ;
//    $published_at = mysqli_real_escape_string($_POST['published_at']);
//
//    $sql = "INSERT INTO articole(title, content, published_at)
//            VALUES ('$title','$content','$published_at')";


// SECOND METHOD to avoid sql injections
// using prepared statements (more secured)
        //1. write sql statement that contains placeholders:
        $sql = "INSERT INTO articole(title, content, published_at)
            VALUES (?,?,?)";
        //2. We prepare the statement:
        $stmt = mysqli_prepare($conn, $sql);

        if($published_at == '') {
            $published_at = null;
        }

        //3. Bind data to the placeholders
        mysqli_stmt_bind_param($stmt, "sss", $title, $content, $published_at);
        //3. Execute the statement :
        if (mysqli_stmt_execute($stmt)) {
            $id = mysqli_insert_id($conn);
            header("Location: article.php?id=$id");
            exit;
        } else {
            echo 'Something is wrong';
        }
    }
}

?>

<?php
 require 'includes/header.php';

 ?>

<h2>New article</h2>

<?php if(!empty($errors)): ?>
    <div>
        <ul>
            <?php foreach ($errors as $error): ?>
            <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="post">
    <div>
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" value="<?= htmlspecialchars($title) ?>">
    </div>
    <div>
        <label for="content">Content</label>
        <textarea name="content" placeholder="Article content" id="content"><?= htmlspecialchars($content) ?></textarea>
    </div>
    <div>
        <label for="published_at">Publication date and time</label>
        <input type="datetime-local" name="published_at" id="published_at" value="<?= htmlspecialchars($published_at) ?>">
    </div>

    <button>Add</button>

</form>

<?php require 'includes/footer.php';