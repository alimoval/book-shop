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
        } elseif($method == "POST"){
            $result = $service->postCar();
            if($result){
                echo json_encode(array(
                    'message' => 'Post Created'
                ));
            } else {
                echo json_encode(array(
                    'message' => 'Post Not Created'
                ));
            }
        }


    }

}
