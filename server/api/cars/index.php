<?php

require_once '../../libs/RESTServer.php';
require_once '../../libs/CarsService.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$carsService = new CarsService();
$server = new RESTServer($carsService);


