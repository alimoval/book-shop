<?php

class RESTServer
{
    public function __construct($class)
    {   
        $controllerClass = $class;
        echo $queryString = $_SERVER['QUERY_STRING'];
        echo $controllerMethod = $_SERVER['REQUEST_METHOD'];
        echo $uri = $_SERVER['REQUEST_URI'];
        print_r($_SERVER);

        list($e, $s, $a, $table) = explode("/", $uri);
        echo $table;

        if($method == "GET"){

            return call_user_func_array([new $controllerClass(), $controllerMethod], [$currentArgumentPart]);
        }
    }
}
