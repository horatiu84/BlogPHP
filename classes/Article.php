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
    public $image_file;
    public $errors =[];
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
    public static function getPage($conn,$limit,$offset, $only_published = false){

        $condition = $only_published ? ' WHERE published_at IS NOT NULL' : '';

        $sql = "SELECT a.*,category.name AS category_name
                FROM (SELECT *
                FROM articole
                $condition
                ORDER BY published_at
                LIMIT :limit
                OFFSET :offset) AS a
                LEFT JOIN aricole_category
                ON a.id = aricole_category.articole_id
                LEFT JOIN category
                ON aricole_category.category_id = category.id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':limit',$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset',$offset, PDO::PARAM_INT);

        $stmt->execute();

        $results= $stmt->fetchAll(PDO::FETCH_ASSOC);

        $articles = [];

        $previous_id = null;

        foreach ($results as $row) {
            $article_id = $row['id'];
            //$article_id = 33
            if ($article_id != $previous_id){
                $row['category_names'] = [];
                $articles[$article_id] = $row;

            }
            if ($row['category_name'] !== null) {
                $articles[$article_id]['category_names'][] = $row['category_name'];
            }
        $previous_id = $article_id;
        }
              return $articles;

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
     * Get the article record based on the ID along
     * with the associated categories, if any
     *
     *
     * @param object $conn Connection to the database
     * @param integer $id the article ID
     * @return array The article data with categories
     */
    public static function getWithCategories($conn,$id,$only_published=false) {
        $sql= "SELECT articole.*, category.name AS category_name
               FROM articole
               LEFT JOIN aricole_category
               ON articole.id = aricole_category.articole_id
               LEFT JOIN category
               ON aricole_category.category_id = category.id
               WHERE articole.id = :id";

        if ($only_published) {
            $sql .= ' AND articole.published_at IS NOT NULL';
        }

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id,PDO::PARAM_INT);

        $stmt->execute();

        // as this can return multiple records, we'll return
        // an associative array

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get the article's categories
     *
     * @param object $conn Connection to the database
     * @return array The category data
     */
    public function getCategories($conn){
        $sql = "SELECT category.*
                FROM category
                JOIN aricole_category
                ON category.id = aricole_category.category_id
                WHERE articole_id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id',$this->id,PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function setCategories($conn,$ids)
    {
        if($ids) {
            $sql = "INSERT IGNORE INTO aricole_category (articole_id,category_id)
                    VALUES ";

            $values = [];

            foreach ($ids as $id) {
                $values[] = "({$this->id}, ?)";
            }

            $sql .= implode(", ",$values);


            $stmt = $conn->prepare($sql);


            foreach ($ids as $i=>$id) {
                $stmt->bindValue($i+1,$id, PDO::PARAM_INT);
            }
            $stmt->execute();

        }
        $sql = "DELETE FROM aricole_category
                WHERE articole_id = {$this->id}";

        if ($ids) {
            $placeholders = array_fill(0,count($ids),'?');
            $sql .= " AND category_id NOT IN (" .implode(",",$placeholders) .")";
        }



        $stmt=$conn->prepare($sql);

        foreach ($ids as $i=>$id) {
            $stmt->bindValue($i+1,$id, PDO::PARAM_INT);
        }

        $stmt->execute();



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
    public static function getTotal($conn,$only_published = false) {
        $condition = $only_published ? 'WHERE published_at IS NOT NULL' : '';
        $sql = "SELECT COUNT(*) FROM articole $condition";
        $result = $conn->query($sql);
        return $result->fetchColumn();
    }

    /**
     * Update the image file property
     * @param object $conn Connection to the database
     * @param string $filename the filename of the image file
     * @return boolean True if it was successful, false if not
     */
    public function setImageFile($conn,$filename) {
        $sql = "UPDATE articole
                SET image_file = :image_file
                WHERE id = :id";
        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':id',$this->id,PDO::PARAM_INT);
        $stmt->bindValue(':image_file',$filename, $filename== null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        return $stmt->execute();
    }

}