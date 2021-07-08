<?php
namespace Finizens\Domain\Repository;

use Finizens\Domain\Entity\PortfolioEntity;

Interface AllocationRepositoryInterface
{
    public function update(PortfolioEntity $portfolioEntity);
    
    public function findAllocationByPortfolio($portfolioId);
    
    public function findAllocationById($allocationId, $portfolioId);
    
    public function resetAllocationByPortfolio($portfolioId);
    
    public function create($allocationEntity);
    
    public function updateAllocation($allocationEntity);
   
}
