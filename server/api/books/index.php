<?php

require_once '../../libs/RESTServer.php';
require_once '../../libs/BooksService.php';

$booksService = new BooksService();
$server = new RESTServer($booksService);