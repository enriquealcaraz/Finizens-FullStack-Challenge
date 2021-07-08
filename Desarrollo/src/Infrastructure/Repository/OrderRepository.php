<?php
namespace Finizens\Infrastructure\Repository;

use Finizens\Infrastructure\Eloquent\OrderModel;
use Finizens\Domain\Repository\OrderRepositoryInterface;
use Finizens\Domain\Entity\OrderEntity;
use Finizens\Domain\Exception\NotFoundOrderException;

class OrderRepository implements OrderRepositoryInterface
{
    public function createOrder(OrderEntity $orderEntity)
    {
        $orderModel = new OrderModel();
        $orderModel->id = $orderEntity->id();
        $orderModel->portfolio = $orderEntity->portfolio();
        $orderModel->allocation = $orderEntity->allocation();
        $orderModel->shares = $orderEntity->shares();
        $orderModel->type = $orderEntity->type();
        $orderModel->status = $orderEntity->status();
        
        $orderModel->save();
    }
    
    public function resetOrderByPortfolio($portfolioId)
    {
        OrderModel::where('portfolio', $portfolioId)->delete();
    }
    
    public function findOrderById($id)
    {
        $orderModel = OrderModel::where('id', $id)->first(); 
        
        if (!isset($orderModel->id)) {
            throw new NotFoundOrderException();
        }
        
        return new OrderEntity($orderModel->id, $orderModel->portfolio, $orderModel->allocation, $orderModel->shares, $orderModel->type, $orderModel->status);
    }
    
    public function completeOrder($id)
    {
        $orderModel = OrderModel::where('id', $id)->first();
        $orderModel->status = OrderEntity::COMPLETE;

        $orderModel->save();
    }
    
    public function findOrderByPortfolio($portfolioId)
    {
        $orders = OrderModel::where('portfolio', $portfolioId)->get();
        $orderEntities = array();
        
        foreach($orders as $order) {
            $orderEntities[] = new OrderEntity($order->id, $order->portfolio, $order->allocation, $order->shares, $order->type, $order->status);
        }

        return $orderEntities;
    }
}
