<?php
require_once 'Response.php';

class JsonResponse extends Response
{
    public function __construct($data = null, $status = 200, array $headers = array())
    {
        $data = json_encode($data);
        $headers = array_merge($headers, ['Content-Type' => 'application/json']);
        parent::__construct($data, $status, $headers);
    }
}