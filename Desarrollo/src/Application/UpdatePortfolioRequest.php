<?php
namespace Finizens\Application;

class UpdatePortfolioRequest 
{
    private $portfolioId;
    
    private $allocations;
    
    public function __construct(int $portfolioId, array $allocations) 
    {
        $this->portfolioId = $portfolioId;
        $this->allocations = $allocations;
    }
    
    public function portfolioId() 
    {
        return $this->portfolioId;
    }

    public function allocations() 
    {
        return $this->allocations;
    }
}
