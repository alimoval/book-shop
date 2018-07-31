<?php

$queryString = $_SERVER['QUERY_STRING'];
$method = $_SERVER['REQUEST_METHOD'];

echo $queryString;
echo $method;

if($queryString == 'cars'){
    
}