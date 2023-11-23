<?php

/**
 * A connection to the database
 */
class Database
{
    /**
     * function to get the database connection
     * @return PDO object Connection to the database server
     */
    public function getConn() {
        $db_host = 'localhost';
        $db_user = 'root';
        $db_pass = '';
        $db_name = 'test';

        $dsn = 'mysql:host='.$db_host.';dbname='.$db_name.'; charset=utf8';
        try {
            $db = new PDO($dsn,$db_user,$db_pass);
            $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }

    }
}