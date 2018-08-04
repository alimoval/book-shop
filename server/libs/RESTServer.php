<?php

class RESTServer
{
    public function __construct($service)
    {
        // $queryString = $_SERVER['QUERY_STRING'];
        $method = $_SERVER['REQUEST_METHOD'];

        $url = $_SERVER['REQUEST_URI'];
        list($a, $b, $c, $table, $id) = explode("/", $url);

        if ($method == "GET") {
            if ($id > 0) {
                $result = $service->getCar($id);
            } else {
                $result = $service->getCars();
            }
            print_r(json_encode($result));
        } elseif ($method == "POST") {
            header('Access-Control-Allow-Methods: POST');
            $result = $service->postCar();
        } elseif ($method == "PUT") {
            header('Access-Control-Allow-Methods: PUT');
            $result = $service->updateCar($id);
        } elseif ($method == "DELETE") {
            header('Access-Control-Allow-Methods: DELETE');
            $result = $service->deleteCar($id);
        }

    }

}
