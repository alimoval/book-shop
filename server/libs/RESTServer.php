<?php

class RESTServer
{
    public function __construct($service)
    {
        echo $queryString = $_SERVER['QUERY_STRING'];
        echo $controllerMethod = $_SERVER['REQUEST_METHOD'];
        echo $uri = $_SERVER['REQUEST_URI'];
        // list($s, $a, $d, $db, $table, $path) = explode('/', $url, 6); 
        // list($e, $s, $a, $table) = explode("/", $uri);
        // echo $table;

        // if($method == "GET"){

        //     return call_user_func_array([new $controllerClass(), $controllerMethod], [$currentArgumentPart]);
        // }

        $result = $service->getCars();
        $num = $result->rowCount();

        if ($num > 0) {
            $cars_array = array();
            $cars_array['data'] = array();

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $car = array(
                    'id' => $id,
                    'model' => $model,
                    'tm' => $tm,
                    'price' => $price,
                    'color' => $color,
                    'year' => $year,
                    'gas' => $gas,
                    'odo' => $odo,
                    'engine' => $engine,
                    'town' => $town,
                    'images' => $images,
                );

                array_push($cars_array['data'], $car);
            }

            echo json_encode($cars_array);
        } else {
            echo json_encode(array('message' => 'No cars found'));
        }

    }
}
