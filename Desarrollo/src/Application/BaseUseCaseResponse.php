<?php
namespace Finizens\Application;

class BaseUseCaseResponse
{
    const STATUS_OK = 200;    
    const STATUS_INTERNAL_SERVER_ERROR = 500;
    const STATUS_BAD_REQUEST = 400;
    const STATUS_NO_CONTENT = 404;
    
    private $code;
    
    private $body;
    
    public function __construct($code, $body) 
    {
        $this->code = $code;
        $this->body = $body;
    }
    
    public function code() 
    {
        return $this->code;
    }

    public function body() 
    {
        return $this->body;
    }
}


