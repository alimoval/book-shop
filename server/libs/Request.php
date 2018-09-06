<?php

class Request
{
    private $method;
    private $domain;
    private $path = '';
    private $headers = [];
    private $queryParams = [];
    private $bodyParams;

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function getBodyParams()
    {
        return $this->bodyParams;
    }

    public static function fromGlobals()
    {
        $request              = new self();
        $request->method      = $_SERVER['REQUEST_METHOD'];
        $request->domain      = $_SERVER['HTTP_HOST'];
        $request->path        = strtok($_SERVER['REQUEST_URI'], '?');
        $request->queryParams = $_GET;

        $body                = file_get_contents('php://input');
        $request->bodyParams = self::isJson($body) ? json_decode($body, true) : $body;

        $request->headers = self::getRequestHeaders();

        return $request;
    }

    public static function isJson($string)
    {
        json_decode($string);

        return (json_last_error() == JSON_ERROR_NONE);
    }

    private static function getRequestHeaders()
    {
        $headers = array();
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) <> 'HTTP_') {
                continue;
            }
            $header           = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$header] = $value;
        }

        return $headers;
    }
}
