<?php

require_once '../../libs/RESTServer.php';
require_once '../../libs/CarsService.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');

$carsService = new CarsService();
$server = new RESTServer($carsService);


