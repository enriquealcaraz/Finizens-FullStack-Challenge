<?php
namespace Finizens\Infrastructure\Service;

use Finizens\Domain\Service\PortfolioServiceInterface;
use Finizens\Domain\Entity\PortfolioEntity;
use Finizens\Domain\Repository\AllocationRepositoryInterface;
use Finizens\Domain\Repository\OrderRepositoryInterface;

class PortfolioService implements PortfolioServiceInterface
{
    private $allocationRepository;
    
    private $orderRepository;
    
    public function __construct(
        AllocationRepositoryInterface $allocationRepository,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->allocationRepository = $allocationRepository;
        $this->orderRepository = $orderRepository;
    }
    
    public function update(PortfolioEntity $portfolioEntity)
    {
        $this->allocationRepository->update($portfolioEntity);
    }
    
    public function findAllocationbyPortfolio($portfolioId)
    {
        return $this->allocationRepository->findAllocationByPortfolio($portfolioId);
    }
    
    public function resetPortfolioById($portfolioId)
    {
        $this->orderRepository->resetOrderByPortfolio($portfolioId);        
        $this->allocationRepository->resetAllocationByPortfolio($portfolioId);        
    }
}
