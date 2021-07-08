<?php
namespace Finizens\Application;

use Finizens\Application\CompleteRequest;
use Finizens\Application\CompleteResponse;
use Finizens\Domain\Service\OrderServiceInterface;
use Finizens\Domain\Entity\OrderEntity;
use Finizens\Domain\Service\AllocationServiceInterface;
use Finizens\Domain\Entity\AllocationEntity;
use Finizens\Domain\Exception\NotFoundOrderException;
use Finizens\Domain\Service\ValidationServiceInterface;
use Finizens\Domain\Exception\PayloadValidateException;

class CompleteUseCase
{
    private $orderService;
    
    private $validationService;
    
    private $allocationService;
    
    public function __construct(
        OrderServiceInterface $orderService,
        AllocationServiceInterface $allocationService    
    ) {
        $this->orderService = $orderService;       
        $this->allocationService = $allocationService;
    }
    
    public function execute(CompleteRequest $completeRequest)
    {
        $code = completeResponse::STATUS_OK;
        $body = null;
        try {
            $orderEntity = $this->orderService->findOrderById($completeRequest->id());
            $allocationEntity = $this->allocationService->findAllocationById($orderEntity->allocation(), $orderEntity->portfolio());
            
            if (empty($allocationEntity)) {
                $allocationEntity = new AllocationEntity($orderEntity->allocation(), $orderEntity->shares(), $orderEntity->portfolio());
                $this->allocationService->create($allocationEntity);
            } else {
                $this->allocationService->update($this->operationShares($orderEntity, $allocationEntity));
            }
            
            $this->orderService->completeOrder($orderEntity->id());        
        } catch (NotFoundOrderException $ex) {
            $code = CompleteResponse::STATUS_NO_CONTENT;
        } catch (\Exception $ex) {
            $body = $ex->getMessage();
            $code = UpdatePortfolioResponse::STATUS_INTERNAL_SERVER_ERROR;
        }
        
        return new CompleteResponse($code, $body);
    }
    
    private function operationShares($orderEntity, $allocationEntity)
    {
        switch ($orderEntity->type()) {
            case OrderEntity::SELL:
                $allocationEntity->removeShares($orderEntity->shares());  
                break;
            case OrderEntity::BUY:
                $allocationEntity->addShares($orderEntity->shares());
                break;
        }
        
        return $allocationEntity;
    }
}
