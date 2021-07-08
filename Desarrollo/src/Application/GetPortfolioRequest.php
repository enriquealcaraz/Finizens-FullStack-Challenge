<?php
namespace Finizens\Application;

class GetPortfolioRequest
{
    private $portfolioId;
    
    public function __construct($portfolioId)
    {
        $this->portfolioId = $portfolioId;
    }
    
    public function portfolioId()
    {
        return $this->portfolioId;
    }
}
