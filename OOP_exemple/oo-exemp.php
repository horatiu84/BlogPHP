<?php

require 'Item.php';
require 'Book.php';

$book1 = new Book();
$book1->name = "Vasile";

echo $book1->getListingDescription();