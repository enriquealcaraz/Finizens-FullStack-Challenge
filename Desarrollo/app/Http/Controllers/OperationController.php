<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Finizens\Application\CreateOrderRequest;
use Finizens\Application\CreateOrderUseCase;
use Illuminate\Http\Request;
use Finizens\Application\CompleteUseCase;
use Finizens\Application\CompleteRequest;
use Illuminate\Support\Facades\Validator;

class OperationController extends Controller
{
    const SELL = "sell";
    const BUY = "buy";
    
    public function buy(Request $request)
    {
        $payload = json_decode($request->getContent(), true);
        $rules = [
            'id' => 'required',
            'portfolio' => 'required',
            'allocation' => 'required',
            'shares' => 'required'
        ];
        
        $validator = Validator::make((!empty($payload)) ? $payload : array(), $rules);
        if (!$validator->passes()) {
            return response(null)->setStatusCode(400);
        }

        $createOrderRequest = new CreateOrderRequest($request->id, $request->portfolio, $request->allocation, $request->shares, self::BUY);
        $useCase = app()->make(CreateOrderUseCase::class);
        $response = $useCase->execute($createOrderRequest);
       
        return response($response->body())->setStatusCode($response->code());
    }
    
    public function sell(Request $request)
    {
        $payload = json_decode($request->getContent(), true);
        $rules = [
            'id' => 'required',
            'portfolio' => 'required',
            'allocation' => 'required',
            'shares' => 'required'
        ];
        
        $validator = Validator::make((!empty($payload)) ? $payload : array(), $rules);
        if (!$validator->passes()) {
            return response(null)->setStatusCode(400);
        }
        
        $createOrderRequest = new CreateOrderRequest($request->id, $request->portfolio, $request->allocation, $request->shares, self::SELL);
        $useCase = app()->make(CreateOrderUseCase::class);
        $response = $useCase->execute($createOrderRequest);
       
        return response($response->body())->setStatusCode($response->code());
    }
    
    public function complete(Request $request)
    {
        $payload = json_decode($request->getContent(), true);
        $rules = [
            'id' => 'required'            
        ];
        
        $validator = Validator::make((!empty($payload)) ? $payload : array(), $rules);
        if (!$validator->passes()) {
            return response(null)->setStatusCode(400);
        }
        
        $completeRequest = new CompleteRequest($request->id);
        $useCase = app()->make(CompleteUseCase::class);
        $response = $useCase->execute($completeRequest);
       
        return response($response->body())->setStatusCode($response->code());
    }    
}
