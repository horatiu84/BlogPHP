<?php

/**
 * Article
 *
 * A piece of writing for publication
 */
class Article {
    public $id;
    public $title;
    public $content;
    public $published_at;
    public $errors;
    /**
     * Get all articles
     * @param $conn object Connection to the database
     * @return array An associative array of all the article records
     */
    public static function getAll($conn){
        $sql = "SELECT *
                FROM articole
                ORDER BY published_at;";
        $results = $conn->query($sql);
        return $results->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get a page of articles
     * @param object $conn Connection to the database
     * @param integer $limit Number of records to return
     * @param integer $offset Number of records to skio
     * @return array An associative array of the page of article records
     */
    public static function getPage($conn,$limit,$offset){
        $sql = "SELECT *
                FROM articole
                ORDER BY published_at
                LIMIT :limit
                OFFSET :offset;";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':limit',$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset',$offset, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /**
     * function that find an article based on the id
     * @param $conn is the connection to the database
     * @param $id provided id of the article
     * @return an object of this class or null.
     */
    public static function getById($conn,$id,$column='*') {

        $sql = "SELECT $column
           FROM articole
           WHERE id= :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id',$id,PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS,'Article');

        if($stmt->execute()) {
            return $stmt->fetch();
        }
    }

    /**
     * Update the article with its current property values
     * @param object $conn is the connection to the database
     * @return boolean true if the update was successful, false otherwise
     */
    public function update($conn) {
        if($this->validate()) {


            $sql = "UPDATE articole 
                SET title = :title,
                    content = :content ,
                    published_at = :published_at
                WHERE id = :id";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
            $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
            $stmt->bindValue(':content', $this->content, PDO::PARAM_STR);
            if ($this->published_at == '') {
                $stmt->bindValue(':published_at', $this->published_at, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':published_at', $this->published_at, PDO::PARAM_STR);
            }

            return $stmt->execute();
        } else {
            return false;
        }
    }

    /**
     * Function that validates the article proprieties
     *
     *
     * @return boolean True if the current prop are valid, false otherwise
     */

    protected function validate() {

        // we validate the form
        if ($this->title == '') {
            $this->errors[]="The title is required";
        }
        if ($this->content == '') {
            $this->errors[]="The content is required";
        }

        return empty($this->errors);

    }

    /**
     * Delete the current article
     * @param object $conn Connection to the database
     * @return boolean True if delete was succesful, false otherwise
     */
    public function delete($conn) {
        $sql = "DELETE FROM articole 
                WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Insert a new article with its current prop values
     * @param object $conn Connection to the database
     * @return boolean True if the insert was successful, fasle otherwise
     */
    public function create($conn) {

        if($this->validate()) {


            $sql = "INSERT INTO articole(title,content,published_at)
                    VALUES (:title,:content,:published_at)";

            $stmt = $conn->prepare($sql);

            $stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
            $stmt->bindValue(':content', $this->content, PDO::PARAM_STR);
            if ($this->published_at == '') {
                $stmt->bindValue(':published_at', $this->published_at, PDO::PARAM_NULL);
            } else {
                $stmt->bindValue(':published_at', $this->published_at, PDO::PARAM_STR);
            }

            if ($stmt->execute()) {
                $this->id = $conn->lastInsertId();
                return true;
            };
        } else {
            return false;
        }
    }

    /**
     * Get a count of the total number of records
     * @param object $conn Connection to the database
     * @return integer The total number of records
     */
    public static function getTotal($conn) {
        $sql = "SELECT COUNT(*) FROM articole";
        $result = $conn->query($sql);
        return $result->fetchColumn();
    }

}