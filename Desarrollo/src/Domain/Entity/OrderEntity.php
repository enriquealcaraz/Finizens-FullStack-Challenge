<?php

namespace Finizens\Domain\Entity;

class OrderEntity 
{
    const SELL = "sell";
    const BUY = "buy";
    const IMCOMPLETE = 0;
    const COMPLETE = 1;
    
    private $id;
    
    private $portfolio;
    
    private $allocation;
    
    private $shares;
    
    private $type;
    
    private $status;
    
    public function __construct($id, $portfolio, $allocation, $shares, $type, $status) {
        $this->id = $id;
        $this->portfolio = $portfolio;
        $this->allocation = $allocation;
        $this->shares = $shares;
        $this->type = $type;
        $this->status = $status;
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
    
    public function status()
    {
        return $this->status;
    }
}
