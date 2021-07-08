<?php
namespace Finizens\Application;

use Finizens\Domain\Service\PortfolioServiceInterface;
use Finizens\Application\GetPortfolioRequest;
use Finizens\Application\GetPortfolioResponse;
use Finizens\Domain\Exception\NotFoundOrderException;

class GetPortfolioUseCase
{
    private $portfolioService;
    
    public function __construct(
        PortfolioServiceInterface $portfolioService        
    ) {
        $this->portfolioService = $portfolioService;        
    }
    
    public function execute(GetPortfolioRequest $getPortfolioRequest)
    {
        $code = UpdatePortfolioResponse::STATUS_OK;
        $body = null;
        try {
            $portfolioEntity = $this->portfolioService->findAllocationbyPortfolio($getPortfolioRequest->portfolioId());
            
            if (empty($portfolioEntity)) {
                throw new NotFoundOrderException();
            }
            
            $body = json_encode($portfolioEntity->toArray());
        } catch (\NotFoundOrderException $ex) {
            $code = UpdatePortfolioResponse::STATUS_NO_CONTENT;
        } catch (\Exception $ex) {
            $body = $ex->getMessage();
            $code = UpdatePortfolioResponse::STATUS_INTERNAL_SERVER_ERROR;
        }

        return new GetPortfolioResponse($code, $body);
    }
}
