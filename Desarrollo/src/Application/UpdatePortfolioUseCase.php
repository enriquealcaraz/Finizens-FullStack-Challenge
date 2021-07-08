<?php
namespace Finizens\Application;

use Finizens\Application\UpdatePortfolioRequest;
use Finizens\Domain\Service\PortfolioServiceInterface;
use Finizens\Domain\Entity\PortfolioEntity;
use Finizens\Application\UpdatePortfolioResponse;
use Finizens\Domain\Entity\AllocationEntity;

class UpdatePortfolioUseCase 
{
    private $portfolioService; 
    
    public function __construct(PortfolioServiceInterface $portfolioService)
    {
        $this->portfolioService = $portfolioService;       
    }
    
    public function execute(UpdatePortfolioRequest $updatePortfolioRequestRequest)
    {
        $code = UpdatePortfolioResponse::STATUS_OK;
        $body = null;
        try {            
            foreach($updatePortfolioRequestRequest->allocations() as $allocation) {
                $allocationEntities[] = new AllocationEntity($allocation["id"], $allocation["shares"], $updatePortfolioRequestRequest->portfolioId());                
            }
            $portfolioEntity = new PortfolioEntity($updatePortfolioRequestRequest->portfolioId(), $allocationEntities);

            $this->portfolioService->resetPortfolioById($portfolioEntity->id());
            $this->portfolioService->update($portfolioEntity);        
        } catch (\Exception $ex) {
            $body = $ex->getMessage();
            $code = UpdatePortfolioResponse::STATUS_INTERNAL_SERVER_ERROR;
        }
        
        return new UpdatePortfolioResponse($code, $body);
    }
}
