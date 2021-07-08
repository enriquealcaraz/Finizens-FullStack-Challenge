<?php
namespace Finizens\Domain\Service;

use Finizens\Domain\Entity\OrderEntity;

Interface OrderServiceInterface
{
    public function createOrder(OrderEntity $orderEntity);
    
    public function completeOrder($id);
    
    public function findOrderById($id);
    
    public function findOrderByPortfolio($portfolioId);
}

