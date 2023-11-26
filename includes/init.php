<?php

spl_autoload_register(function ($class){
    require dirname(__DIR__). "/classes/{$class}.php";
});

/**
 * Defines constant ROOT for subfolder
 */
const ROOT = "/BlogPHP";


session_start();