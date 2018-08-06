<?php

require_once '../../libs/RESTServer.php';
require_once '../../libs/OrdersService.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');

$ordersService = new OrdersService();
$server = new RESTServer($ordersService);