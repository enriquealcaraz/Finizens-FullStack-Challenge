<?php
namespace Finizens\Domain\Repository;

use Finizens\Domain\Entity\OrderEntity;

Interface OrderRepositoryInterface
{
    public function createOrder(OrderEntity $orderEntity);
    
    public function resetOrderByPortfolio($portfolioId);
    
    public function findOrderById($id);
    
    public function completeOrder($id);
    
    public function findOrderByPortfolio($portfolioId);
}
