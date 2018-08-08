<?php

require_once 'JsonResponse.php';
require_once 'Response.php';
require_once 'fpdf.php';

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
        header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');
        if ($viewType == "txt") {
            $jsonResponse = new JsonResponse($this->result['data'], 200, ['Content-Type'=>'text/plain', 'Content-Disposition'=>'attachment; filename="' . $this->table . $this->id . '.txt"']);
            $jsonResponse->send();
        } elseif ($viewType == "xml") {
            $response = new Response(xmlrpc_encode($this->result), 200, ['Content-Type' => 'text/xml', 'Content-Disposition'=>'attachment; filename="' . $this->table . $this->id . '.xml"']);
            $response->send();
        } elseif ($viewType == "pdf") {
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial', 'B', 12);
            foreach ($this->result['data'] as $key => $value) {
                $pdf->MultiCell(190, 10, json_encode($value), 0, 'L');
            }
            $response = new Response($pdf->Output(), 200, [
                'Content-Type'=>'application/pdf',
                'Content-Disposition'=>'attachment; filename="' . $this->table . $this->id . '.pdf"',
                'Content-Transfer-Encoding'=>'binary']);
            $response->send();
        } else {
            // header('Content-Type: application/json');
            // print_r(json_encode($this->result));
            $jsonResponse = new JsonResponse($this->result, 200, ['Content-Type'=>'application/json']);
            $jsonResponse->send();
        }
    }
}
