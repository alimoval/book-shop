<?php

class Cars
{
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
