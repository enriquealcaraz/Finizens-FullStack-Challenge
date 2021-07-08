<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Finizens\Infrastructure\Repository\AllocationRepository;
use Finizens\Infrastructure\Service\PortfolioService;
use Finizens\Application\UpdatePortfolioUseCase;
use Finizens\Application\GetPortfolioUseCase;
use Finizens\Infrastructure\Repository\OrderRepository;
use Finizens\Infrastructure\Service\OrderService;
use Finizens\Application\CreateOrderUseCase;
use Finizens\Application\CompleteUseCase;
use Finizens\Infrastructure\Service\AllocationService;
use Finizens\Application\GetOrderByPortfolioUseCase;

class DDDServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $allocationRepository = new AllocationRepository();
        $orderRepository = new OrderRepository();
                
        $portfolioService = new PortfolioService($allocationRepository, $orderRepository);        
        $orderService = new OrderService($orderRepository, $allocationRepository);
        $allocationService = new AllocationService($allocationRepository);
        
        $this->app->bind(UpdatePortfolioUseCase::class, function ($app) use ($portfolioService) {
            return new UpdatePortfolioUseCase($portfolioService);
        });
        
        $this->app->bind(GetPortfolioUseCase::class, function ($app) use ($portfolioService) {
            return new GetPortfolioUseCase($portfolioService);
        });
        
        $this->app->bind(CreateOrderUseCase::class, function ($app) use ($orderService, $allocationService) {
            return new CreateOrderUseCase($orderService, $allocationService);
        });
        
        $this->app->bind(CompleteUseCase::class, function ($app) use ($orderService, $allocationService) {
            return new CompleteUseCase($orderService, $allocationService);
        });
        
        $this->app->bind(GetOrderByPortfolioUseCase::class, function ($app) use ($orderService) {
            return new GetOrderByPortfolioUseCase($orderService);
        });
    }
}
