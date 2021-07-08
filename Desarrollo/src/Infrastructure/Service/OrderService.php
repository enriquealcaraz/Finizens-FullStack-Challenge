<?php
namespace Finizens\Infrastructure\Service;

use Finizens\Domain\Repository\OrderRepositoryInterface;
use Finizens\Domain\Service\OrderServiceInterface;
use Finizens\Domain\Entity\OrderEntity;
use Finizens\Domain\Repository\AllocationRepositoryInterface;

class OrderService implements OrderServiceInterface
{
    private $orderRepository;
    
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        AllocationRepositoryInterface $allocationRepository    
    ) {
        $this->orderRepository = $orderRepository;
        $this->allocationRepository = $allocationRepository;
    }
    
    public function createOrder(OrderEntity $orderEntity)
    {
        $this->orderRepository->createOrder($orderEntity);
    }
    
    public function completeOrder($id)
    {
        $this->orderRepository->completeOrder($id);
    }
    
    public function findOrderById($id)
    {
        return $this->orderRepository->findOrderById($id);
    }
    
    public function findOrderByPortfolio($portfolioId)
    {
        return $this->orderRepository->findOrderByPortfolio($portfolioId);
    }
}

