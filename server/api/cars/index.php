<?php

require_once '../../libs/RESTServer.php';
require_once '../../libs/CarsService.php';

$carsService = new CarsService();
$server = new RESTServer($carsService);