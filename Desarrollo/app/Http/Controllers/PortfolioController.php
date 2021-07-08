<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Finizens\Application\UpdatePortfolioUseCase;
use Finizens\Application\UpdatePortfolioRequest;
use Finizens\Application\GetPortfolioUseCase;
use Finizens\Application\GetPortfolioRequest;
use Illuminate\Support\Facades\Validator;
use Finizens\Application\GetOrderByPortfolioUseCase;
use Finizens\Application\GetOrderByPortfolioRequest;

class PortfolioController extends Controller
{
    public function update(Request $request)
    {
        $payload = json_decode($request->getContent(), true);
        $rules = [
            'id' => 'required',
            'allocations' => 'required',
            'allocations.*.id' => 'required',
            'allocations.*.shares' => 'required'
        ];
        
        $validator = Validator::make((!empty($payload)) ? $payload : array(), $rules);
        if (!$validator->passes()) {
            return response(null)->setStatusCode(400);
        }
        
        $updatePortfolioRequest = new UpdatePortfolioRequest($request->id, $request->allocations);
        $useCase = app()->make(UpdatePortfolioUseCase::class);
        $response = $useCase->execute($updatePortfolioRequest);
       
        return response($response->body())->setStatusCode($response->code());
    }
    
    public function get($id)
    {
        $getPortfolioRequest = new GetPortfolioRequest($id);
        $useCase = app()->make(GetPortfolioUseCase::class);
        $response = $useCase->execute($getPortfolioRequest);
        
        return response($response->body())->setStatusCode($response->code());
    }
    
    public function getOrders($id)
    {
        $getOrderByPortfolioRequest = new GetOrderByPortfolioRequest($id);
        $useCase = app()->make(GetOrderByPortfolioUseCase::class);
        $response = $useCase->execute($getOrderByPortfolioRequest);
        
        return response($response->body())->setStatusCode($response->code());
    }
}