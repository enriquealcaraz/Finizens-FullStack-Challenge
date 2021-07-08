<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Finizens\Application\CreateOrderUseCase;
use Finizens\Infrastructure\Service\OrderService;
use Finizens\Infrastructure\Service\AllocationService;
use Finizens\Application\CreateOrderRequest;
use Finizens\Application\CreateOrderResponse;
use Finizens\Domain\Entity\AllocationEntity;
use Finizens\Domain\Entity\OrderEntity;

class CreateOrderUseCaseTest extends TestCase
{    
    /** @test */
    public function createBuyOrderTest()
    {
        $orderService = $this->createMock(OrderService::class);
        $allocationService = $this->createMock(AllocationService::class);
        $allocationEntity = new AllocationEntity(1, 3, 1);
 
        $allocationService->method('findAllocationById')->willReturn($allocationEntity);
        
        $this->createOrderUseCase = new CreateOrderUseCase($orderService, $allocationService);
        
        $request = new CreateOrderRequest(1, 1, 1, 3, 'buy');
        $response = $this->createOrderUseCase->execute($request);
        
        $this->assertInstanceOf(CreateOrderResponse::class, $response);
        $this->assertSame(null, $response->body());
        $this->assertSame(200, $response->code());
    }
    
    /** @test */
    public function NotFoundAllocationExceptionTest()
    {
        $orderService = $this->createMock(OrderService::class);
        $allocationService = $this->createMock(AllocationService::class);
         
        $allocationService->method('findAllocationById')->willReturn(null);

        $this->createOrderUseCase = new CreateOrderUseCase($orderService, $allocationService);
        
        $request = new CreateOrderRequest(1, 1, 1, 3, 'buy');
        $response = $this->createOrderUseCase->execute($request);
        
        $this->assertSame(404, $response->code());
        $this->assertSame(null, $response->body());
    }
    
    /** @test */
    public function SellExceededAllocationException()
    {
        $orderService = $this->createMock(OrderService::class);
        $allocationService = $this->createMock(AllocationService::class);
         
        $allocationEntity = new AllocationEntity(1, 3, 1); 
        $allocationService->method('findAllocationById')->willReturn($allocationEntity);

        $this->createOrderUseCase = new CreateOrderUseCase($orderService, $allocationService);
        
        $request = new CreateOrderRequest(1, 1, 1, 43, 'sell');
        $response = $this->createOrderUseCase->execute($request);
        
        $this->assertSame(500, $response->code());
        $this->assertSame(null, $response->body());
    }
    
    /** @test */
    public function createSellOrderTest()
    {
        $orderService = $this->createMock(OrderService::class);
        $allocationService = $this->createMock(AllocationService::class);
        $allocationEntity = new AllocationEntity(1, 3, 1);
 
        $allocationService->method('findAllocationById')->willReturn($allocationEntity);
        
        $this->createOrderUseCase = new CreateOrderUseCase($orderService, $allocationService);
        
        $request = new CreateOrderRequest(1, 1, 1, 3, 'sell');
        $response = $this->createOrderUseCase->execute($request);
        
        $this->assertInstanceOf(CreateOrderResponse::class, $response);
        $this->assertSame(null, $response->body());
        $this->assertSame(200, $response->code());
    }
}
