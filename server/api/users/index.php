<?php

require_once '../../libs/RESTServer.php';
require_once '../../libs/UsersService.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');

$usersService = new UsersService();
$server = new RESTServer($usersService);


