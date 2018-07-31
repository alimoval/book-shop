<?php

require_once '../../libs/RESTServer.php';

class Cars
{

    public function __construct()
    {
        echo 'hello Cars';
    }

    public function getCars($id)
    {
    }

    public function postCars()
    {
        
    }

    public function putCars($id)
    {
    }

    public function deleteCars($id)
    {
    }
}

$server = new RESTServer($cars);
