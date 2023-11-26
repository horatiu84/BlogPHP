<?php

/**
 * User class
 *
 * A person that can log in on the site
 */
class User {
    public $id;
    public $username;
    public $password;
    /**
     * Authenticate a user by username and password
     * @param string $username Username
     * @param string $password Password
     * @return bool True if the credential are correct, null otherwise
     */
    public static function authenticate($conn,$username,$password){
       $sql = "SELECT *
               FROM user
               WHERE username = :username";

       $stmt = $conn->prepare($sql);
       $stmt->bindValue(':username', $username, PDO::PARAM_STR);

       $stmt->setFetchMode(PDO::FETCH_CLASS,'User');
       $stmt->execute();



       if($user = $stmt->fetch()) {
           return password_verify($password,$user->password);
       }

    }
}