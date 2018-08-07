<?php

require_once './JsonResponse.php';

class View
{
    private $result;
    private $table;
    private $id;
    private $viewType;

    public function render($result, $table, $id = null, $viewType)
    {
        $this->result = $result;
        $this->table = $table;
        $this->id = $id;
        $this->viewType = $viewType;
        
        header('Access-Control-Allow-Origin: *');
        if ($viewType == "txt") {
            header('Content-Type: text/plain');
            header('Content-Disposition: attachment; filename="' . $table . $id . '.txt"');
        } elseif ($viewType == "xml") {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment; filename="' . $table . $id . '.xml"');
        } elseif ($viewType == "pdf") {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $table . $id . '.pdf"');
            header('Content-Transfer-Encoding: binary');
        } else {
            header('Content-Type: application/json');
            print_r(json_encode($this->result));
        }
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');
        // print_r(xmlrpc_encode($result));
    }
}
