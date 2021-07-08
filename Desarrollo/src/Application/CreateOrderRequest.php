<?php
namespace Finizens\Application;

class CreateOrderRequest
{
    private $id;
    
    private $portfolio;
    
    private $allocation;
    
    private $shares;
    
    private $type;
    
    public function __construct($id, $portfolio, $allocation, $shares, $type)
    {
        $this->id = $id;
        $this->portfolio = $portfolio;
        $this->allocation = $allocation;
        $this->shares = $shares;
        $this->type = $type;
    }
    
    public function id()
    {
        return $this->id;
    }

    public function portfolio()
    {
        return $this->portfolio;
    }

    public function allocation()
    {
        return $this->allocation;
    }

    public function shares()
    {
        return $this->shares;
    }
    
    public function type()
    {
        return $this->type;
    }
}
