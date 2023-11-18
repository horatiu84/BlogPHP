<?php
/**
 * function for creating the connection with the database
 *
 * @return  object Connection to a mySQL server or false otherwise
 */
function getDb(){
    $db_host = 'localhost';
    $db_name = 'test';
    $db_user = 'root';
    $db_pass = '';

    $conn = mysqli_connect($db_host,$db_user,$db_pass,$db_name);

    return $conn;
}
