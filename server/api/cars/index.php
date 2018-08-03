<?php

require_once '../../libs/RESTServer.php';
require_once '../../libs/CarsService.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// $server = new RESTServer(new Cars());

$carsService = new CarsService();

$result = $carsService->getCars();
$num = $result->rowCount();

if ($num > 0) {
    $cars_array = array();
    $cars_array['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $car = array(
            'id'=>$id,
            'model'=>$model,
            'tm'=>$tm,
            'price'=>$price,
            'color'=>$color,
            'year'=>$year,
            'gas'=>$gas,
            'odo'=>$odo,
            'engine'=>$engine,
            'town'=>$town,
            'images'=>$images
        );

        array_push($cars_array['data'], $car);
    }

    echo json_encode($cars_array);
} else {
    echo json_encode(array('message'=>'No cars found'));
}

$id = explode('/', $_SERVER['REQUEST_URI']);

if(isset($id[4])){
    echo $id[4];
} else {
    
}
