<?php
/**
 * function that find an article based on the id
 * @param $conn is the connection to the database
 * @param $id provided id of the article
 * @return array|false|void|null - associative array with the article props.
 */
function getArticle($conn,$id,$column='*') {
    $sql = "SELECT $column
           FROM articole
           WHERE id= ?";

    $stmt = mysqli_prepare($conn,$sql);

    if (!$stmt) {
        echo mysqli_error($conn);
    } else {
        mysqli_stmt_bind_param($stmt,'i',$id);
        if(mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            return mysqli_fetch_array($result,MYSQLI_ASSOC);
        }
    }
}

/**
 * Function that validates the article proprieties
 *
 * @param string $title Title, required
 * @param string $content Content, required
 * @return array an array of validation error messages
 */

function validateArticle($title,$content) {
    $errors = [];
    // we validate the form
    if ($title == '') {
        $errors[]="The title is required";
    }
    if ($content == '') {
        $errors[]="The content is required";
    }

    return $errors;

}