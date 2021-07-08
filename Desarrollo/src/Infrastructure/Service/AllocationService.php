<?php
namespace Finizens\Infrastructure\Service;

use Finizens\Domain\Entity\AllocationEntity;
use Finizens\Domain\Service\AllocationServiceInterface;
use Finizens\Domain\Repository\AllocationRepositoryInterface;

class AllocationService implements AllocationServiceInterface
{    
    private $allocationRepository;
    
    public function __construct(       
        AllocationRepositoryInterface $allocationRepository    
    ) {        
        $this->allocationRepository = $allocationRepository;
    }
    
    public function create(AllocationEntity $allocationEntity)
    {
        $this->allocationRepository->create($allocationEntity);
    }
    
    public function update(AllocationEntity $allocationEntity)
    {
        $this->allocationRepository->updateAllocation($allocationEntity);
    }
    
    public function findAllocationById($allocationId, $portfolioId)
    {
        return $this->allocationRepository->findAllocationById($allocationId, $portfolioId);
    }
}


