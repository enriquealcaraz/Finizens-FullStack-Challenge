<?php

namespace Finizens\Domain\Entity;

class AllocationEntity 
{
    private $id;
    
    private $shares;
    
    private $portfolio;
    
    public function __construct($id, $shares, $portfolio)
    {
        $this->id = $id;
        $this->shares = $shares;
        $this->portfolio = $portfolio;
    }

    public function shares()
    {
        return $this->shares;
    }
    
    public function id()
    {
        return $this->id;
    }
    
    public function portfolio()
    {
        return $this->portfolio;
    }
    
    public function removeShares($shares)
    {
        $this->shares = $this->shares - $shares;
    }
    
    public function addShares($shares)
    {
        $this->shares = $this->shares + $shares;
    }
}
