<?php
require_once 'View.php';

class RESTServer
{
    private $view;

    public function __construct($service)
    {
        $this->view = new View();
        $method = $_SERVER['REQUEST_METHOD'];
        $query = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
        $url = $_SERVER['REQUEST_URI'];
        $urlArray = explode("/", $url);
        $key = array_search('api', $urlArray);
        $table = $urlArray[$key+1];
        $id = $urlArray[$key+2];
        list($id, $viewType) = explode(".", $id);
        if ($method == "GET") {
            if('?'.$query == $id){
                list($param, $value) = explode("=", $query);
                $result = $service->getAllFiltered($value);
            } elseif ($id > 0) {
                $result = $service->getOne($id);
            } else {
                $result = $service->getAll();
            }
        } elseif ($method == "POST") {
            if ($id === 'login') {
                $result = $service->login();
            } else {
                $result = $service->post();    
            }
        } elseif ($method == "PUT") {
            $result = $service->update($id);
        } elseif ($method == "DELETE") {
            $result = $service->delete($id);
        }
        header('Access-Control-Allow-Origin: *'); 
        $this->view->render($result, $table, $id, $viewType);
    }
}
