<?php
require_once './View.php';

class RESTServer
{   
    private $view;

    public function __construct($service)
    {
        $this->view = new View();
        $method = $_SERVER['REQUEST_METHOD'];
        $url = $_SERVER['REQUEST_URI'];
        list($a, $b, $c, $table, $id) = explode("/", $url);
        list($id, $viewType) = explode(".", $id);
        
        if ($method == "GET") {
            if ($id > 0) {
                $result = $service->getOne($id);
            } else {
                $result = $service->getAll();
            }
            $this->view->render($result, $table, $id, $viewType);
        } elseif ($method == "POST") {
            $result = $service->post();
        } elseif ($method == "PUT") {
            $result = $service->update($id);
        } elseif ($method == "DELETE") {
            $result = $service->delete($id);
        }
    }
}
