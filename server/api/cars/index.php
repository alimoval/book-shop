<?php

require_once '../libs/RESTServer.php';

class Cars
{

    public function __construct()
    {
        echo 'hello';
    }

    public function getCars($id)
    {
    }

    public function postCars()
    {
        $queryString = $_SERVER['QUERY_STRING'];
        $method = $_SERVER['REQUEST_METHOD'];

        return $method;
    }

    public function putCars($id)
    {
    }

    public function deleteCars($id)
    {
    }
}

$obj = new RESTServer();
