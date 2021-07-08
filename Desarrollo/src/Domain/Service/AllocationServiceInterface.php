<?php
namespace Finizens\Domain\Service;

use Finizens\Domain\Entity\AllocationEntity;

Interface AllocationServiceInterface
{
    public function create(AllocationEntity $allocationEntity);

    public function update(AllocationEntity $allocationEntity);    
    
    public function findAllocationById($allocationId, $portfolioId);
}
