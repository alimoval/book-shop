<?php
require_once 'View.php';
// require_once '../config.php';

class RESTServer
{   
    private $view;

    public function __construct($service)
    {
        $this->view = new View();
        $method = $_SERVER['REQUEST_METHOD'];
        $url = $_SERVER['REQUEST_URI'];
        list($a, $b, $c, $d, $e, $table, $id) = explode("/", $url);
        list($id, $viewType) = explode(".", $id);
        if ($method == "GET") {
            if ($id > 0) {
                $result = $service->getOne($id);
            } else {
                $result = $service->getAll();
            }
        } elseif ($method == "POST") {
            $result = $service->post();
        } elseif ($method == "PUT") {
            $result = $service->update($id);
        } elseif ($method == "DELETE") {
            $result = $service->delete($id);
        }
        $this->view->render($result, $table, $id, $viewType);
    }
}