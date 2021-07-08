<?php
namespace Finizens\Infrastructure\Repository;

use Finizens\Infrastructure\Eloquent\AllocationModel;
use Finizens\Domain\Repository\AllocationRepositoryInterface;
use Finizens\Domain\Entity\PortfolioEntity;
use Finizens\Domain\Entity\AllocationEntity;

class AllocationRepository implements AllocationRepositoryInterface
{
    public function update(PortfolioEntity $portfolioEntity)
    {
        foreach($portfolioEntity->allocations() as $allocation) {  
            $allocationModel = new AllocationModel();
            $allocationModel->id = $allocation->id();
            $allocationModel->shares = $allocation->shares();
            $allocationModel->portfolio = $portfolioEntity->id();
            
            $allocationModel->save();            
        }        
    }
    
    public function findAllocationByPortfolio($portfolioId)
    {
        $allocations = AllocationModel::where('portfolio', $portfolioId)->get();
        
        $allocationEntities = array();
        foreach($allocations as $allocation) {
            $allocationEntities[] = new AllocationEntity($allocation->id, $allocation->shares, $allocation->portfolio);
        }
        
       return new PortfolioEntity($portfolioId, $allocationEntities);      
    }
    
    public function findAllocationById($allocationId, $portfolioId)
    {
        $allocations = AllocationModel::where(['portfolio' => $portfolioId, 'id' => $allocationId])->first();
       
        if (isset($allocations->id)) {
            return new AllocationEntity($allocations->id, $allocations->shares, $allocations->portfolio);
        }
        
        return null;        
    }
    
    public function resetAllocationByPortfolio($portfolioId)
    {
        AllocationModel::where('portfolio', $portfolioId)->delete();
    }
    
    public function create($allocationEntity)
    {
        $allocationModel = new AllocationModel();        
        $allocationModel->id = $allocationEntity->id();
        $allocationModel->portfolio = $allocationEntity->portfolio();
        $allocationModel->shares = $allocationEntity->shares();

        $allocationModel->save();
        
    }
    
    public function updateAllocation($allocationEntity)
    {
        $allocationModel = AllocationModel::where('id', $allocationEntity->id())->first();
        
        if ($allocationEntity->shares() == 0) {
            $allocationModel->delete();
        } else {
            $allocationModel->shares = $allocationEntity->shares();
            $allocationModel->portfolio = $allocationEntity->portfolio();
        
            $allocationModel->save();
        }
    }
}
