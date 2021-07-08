<?php
namespace Finizens\Domain\Service;

use Finizens\Domain\Entity\PortfolioEntity;

Interface PortfolioServiceInterface
{
    public function update(PortfolioEntity $portfolioEntity);
    
    public function findAllocationbyPortfolio($portfolioId);
      
    public function resetPortfolioById($portfolioEntity);
}
