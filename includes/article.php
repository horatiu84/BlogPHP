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
           WHERE id= :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id',$id,PDO::PARAM_INT);

        if($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
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