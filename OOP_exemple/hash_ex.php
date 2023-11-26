<?php

$password = 'secret';

//$hash = password_hash($password,PASSWORD_DEFAULT);
//
//echo $hash;

$hash = '$2y$10$u4JHYA7jkDePcn.5EGiwqO2GnC7qHMvaLMGRmU1luiwGj/HifSDRm';
var_dump(password_verify($password,$hash));