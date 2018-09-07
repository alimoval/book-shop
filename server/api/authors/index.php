<?php

require_once '../../libs/RESTServer.php';
require_once '../../libs/AuthorsService.php';

$authorsService = new AuthorsService();
$server = new RESTServer($authorsService);