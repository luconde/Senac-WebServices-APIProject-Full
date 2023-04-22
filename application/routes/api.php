<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\MarcaController;
use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\PedidoController;
use App\Http\Controllers\Api\ProdutoController;
use App\Http\Controllers\Api\ItemdopedidoController;
use App\Http\Controllers\Api\PassportAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('localization')->group(function() {
    //Rota para criar um novo usuario
    Route::post('register', [PassportAuthController::class, 'register']);

    // Rota a função de login
    Route::post('login', [PassportAuthController::class, 'login']);

    // As próximas rotas estarão sob a vigilância da autorização
    Route::middleware('auth:api')->group(function() {
        // Rota para função de logout 
        Route::post('logout', [PassportAuthController::class, 'logout']);

        // Rota para coleta informações do usuario
        Route::get('user', [PassportAuthController::class, 'userInfo']);

        // Rota para categorias
        Route::apiResource('categorias', CategoriaController::class);
        
        // Rota para marcas
        Route::apiResource('marcas', MarcaController::class);
        
        // Rota para clientes
        Route::apiResource('clientes', ClienteController::class);
        
        // Rota para os produtos
        Route::apiResource('produtos', ProdutoController::class);
        
        // Rota para os produtos
        Route::apiResource('clientes.pedidos', PedidoController::class)->shallow();
        
        // Rota para os produtos
        Route::apiResource('pedidos.itensdopedido', ItemdopedidoController::class);
    });
});
