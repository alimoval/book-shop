<?php

class RESTServer
{
    public function __construct($service)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = $_SERVER['REQUEST_URI'];
        list($a, $b, $c, $table, $id) = explode("/", $url);
        list($id, $viewType) = explode(".", $id);
        
        header('Access-Control-Allow-Origin: *');
        if ($viewType == "txt") {
            header('Content-type: text/plain');
            header('Content-Disposition: attachment; filename="' . $table . $id . '.txt"');
        } elseif ($viewType == "xml") {
            header('Content-type: text/xml');
            header('Content-Disposition: attachment; filename="' . $table . $id . '.xml"');
        } else {
            header('Content-Type: application/json');
        }
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');

        if ($method == "GET") {
            if ($id > 0) {
                $result = $service->getOne($id);
            } else {
                $result = $service->getAll();
            }
            print_r(json_encode($result));
        } elseif ($method == "POST") {
            $result = $service->post();
        } elseif ($method == "PUT") {
            $result = $service->update($id);
        } elseif ($method == "DELETE") {
            $result = $service->delete($id);
        }
    }
}
