<?php

require_once '../../libs/RESTServer.php';
require_once '../../libs/GenresService.php';

$genresService = new GenresService();
$server = new RESTServer($genresService);