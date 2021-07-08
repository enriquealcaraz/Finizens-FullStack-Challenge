<?php
namespace Finizens\Application;

use Finizens\Application\CreateOrderRequest;
use Finizens\Domain\Service\OrderServiceInterface;
use Finizens\Domain\Entity\OrderEntity;
use Finizens\Application\CreateOrderResponse;
use Finizens\Domain\Exception\NotFoundAllocationException;
use Finizens\Domain\Exception\SellExceededAllocationException;
use Finizens\Domain\Service\AllocationServiceInterface;

class CreateOrderUseCase 
{
    private $orderService;
    
    private $allocationService;
    
    public function __construct(       
        OrderServiceInterface $orderService,
        AllocationServiceInterface $allocationService        
    ) {
        $this->orderService = $orderService;
        $this->allocationService = $allocationService;        
    }
    
    public function execute(CreateOrderRequest $createOrderRequest)
    {
        $code = CreateOrderResponse::STATUS_OK;
        $body = null;
        try {
            $allocation = $this->findAllocationIfExist($createOrderRequest->allocation(), $createOrderRequest->portfolio());

            if ($createOrderRequest->type() == OrderEntity::SELL && $allocation->shares() < $createOrderRequest->shares()) {                                
                throw new SellExceededAllocationException();
            }
            
            $orderEntity = new OrderEntity($createOrderRequest->id(), $createOrderRequest->portfolio(),
                $createOrderRequest->allocation(), $createOrderRequest->shares(), $createOrderRequest->type(), OrderEntity::IMCOMPLETE);
        
            $this->orderService->createOrder($orderEntity);        
        } catch (NotFoundAllocationException $ex) {
            $code = CreateOrderResponse::STATUS_NO_CONTENT;        
        } catch (SellExceededAllocationException $ex) {
            $code = CreateOrderResponse::STATUS_INTERNAL_SERVER_ERROR;
        } catch (\Exception $ex) {
            $body = $ex->getMessage();
            $code = CreateOrderResponse::STATUS_INTERNAL_SERVER_ERROR;
        }
        
        return new CreateOrderResponse($code, $body);
    }
    
    private function findAllocationIfExist($allocation, $portfolio)
    {
        $allocationEntity = $this->allocationService->findAllocationById($allocation, $portfolio);
        
        if (empty($allocationEntity)) {
            throw new NotFoundAllocationException();
        }
        
        return $allocationEntity;
    }
}
