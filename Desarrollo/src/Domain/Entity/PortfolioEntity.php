<?php

namespace Finizens\Domain\Entity;

class PortfolioEntity 
{
    private $id;
    
    private $allocations;
    
    public function __construct($id, $allocations)
    {
        $this->id = $id;
        $this->allocations = $allocations;
    }
    
    public function id()
    {
        return $this->id;
    }

    public function allocations()
    {
        return $this->allocations;
    }
    
    // TO DO - move it to domain service
    public function toArray()
    {
        $allocationArray = array();
        foreach($this->allocations() as $allocation) {
            $allocationArray[] = array(
                "id" => $allocation->id(),
                "shares" => $allocation->shares()
            );
        }
        
        return [
            "id" => $this->id(),
            "allocations" => $allocationArray
        ];
    }
}
