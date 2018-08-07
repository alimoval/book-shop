<?php

require_once 'JsonResponse.php';

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
            header('Content-Type: text/plain');
            header('Content-Disposition: attachment; filename="' . $this->table . $this->id . '.txt"');
            print_r(json_encode($this->result['data']));
        } elseif ($viewType == "xml") {
            header('Content-Type: text/xml');
            header('Content-Disposition: attachment; filename="' . $this->table . $this->id . '.xml"');
            print_r(xmlrpc_encode($this->result));
        } elseif ($viewType == "pdf") {
            header('Content-Type: application/pdf');
            // header('Content-Disposition: attachment; filename="' . $this->table . $this->id . '.pdf"');
            header('Content-Transfer-Encoding: binary');
            try {
                $p = new PDFlib();
            
                /*  Создание нового PDF-файла с указанием имени PDF-файла на диске */
                if ($p->begin_document("", "") == 0) {
                    die("Error: " . $p->get_errmsg());
                }
            
                $p->begin_page_ext(595, 842, "");
            
                $font = $p->load_font("Helvetica-Bold", "winansi", "");
            
                $p->setfont($font, 24.0);
                $p->set_text_pos(50, 700);
                $p->show("Hello world!");
                $p->continue_text("(says PHP)");
                $p->end_page_ext("");
            
                $p->end_document("");
            
                $buf = $p->get_buffer();
                $len = strlen($buf);
            
                header("Content-Length: $len");
                header("Content-Disposition: inline; filename=hello.pdf");
                print $buf;
            } catch (PDFlibException $e) {
                die("PDFlib exception occurred in hello sample:\n" .
                "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
                $e->get_errmsg() . "\n");
            } catch (Exception $e) {
                die($e);
            }
            $p = 0;
        } else {
            header('Content-Type: application/json');
            print_r(json_encode($this->result));
        }
    }
}
