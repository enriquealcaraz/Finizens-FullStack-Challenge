<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\OperationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::put('/portfolio', [PortfolioController::class, 'update']);
Route::get('/portfolio/{id}', [PortfolioController::class, 'get']);
Route::patch('/portfolio/{id}', function () { return response('', 405); });
Route::patch('/portfolio', function () { return response('', 405); });

Route::post('/sell', [OperationController::class, 'sell']);
Route::put('/sell', function () { return response('', 405); });

Route::post('/buy', [OperationController::class, 'buy']);
Route::put('/buy', function () { return response('', 405); });

Route::post('/complete', [OperationController::class, 'complete']);
Route::put('/complete', function () { return response('', 405); });

Route::get('/orders/{id}', [PortfolioController::class, 'getOrders']);