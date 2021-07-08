<?php
namespace Finizens\Application;

use Finizens\Domain\Service\OrderServiceInterface;
use Finizens\Application\GetOrderByPortfolioRequest;
use Finizens\Application\GetOrderByPortfolioResponse;
use Finizens\Domain\Exception\NotFoundOrderException;

class GetOrderByPortfolioUseCase
{
    private $orderService;
    
    public function __construct(
        OrderServiceInterface $orderService        
    ) {
        $this->orderService = $orderService;        
    }
    
    public function execute(GetOrderByPortfolioRequest $getOrderByPortfolioRequest)
    {
        $code = GetOrderByPortfolioResponse::STATUS_OK;
        $body = null;
        try {
            $orderEntities = $this->orderService->findOrderByPortfolio($getOrderByPortfolioRequest->portfolioId());
            
            if (empty($orderEntities)) {
                throw new NotFoundOrderException();
            }
            
            $body = json_encode($this->convertToArray($orderEntities));
        } catch (NotFoundOrderException $ex) {
            $code = GetOrderByPortfolioResponse::STATUS_NO_CONTENT;
        } catch (\Exception $ex) {
            $body = $ex->getMessage();
            $code = GetOrderByPortfolioResponse::STATUS_INTERNAL_SERVER_ERROR;
        }

        return new GetOrderByPortfolioResponse($code, $body);
    }
    
    // TO DO - move it to domain service
    public function convertToArray($orderEntities)
    {
        foreach($orderEntities as $orderEntity) {
            $orderArray[] = array(
                "id" => $orderEntity->id(),
                "portfolio" => $orderEntity->portfolio(),
                "allocation" =>$orderEntity->allocation(),
                "shares" => $orderEntity->shares(),
                "type" => $orderEntity->type(),
                "status" => $orderEntity->status()
            );
        }        
        return $orderArray;
    }
}
