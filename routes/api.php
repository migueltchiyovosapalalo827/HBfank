<?php

//use App\Http\Controllers\Auth\LoginController;

//use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});


Route::middleware('auth:sanctum')->post('/logout', [App\Http\Controllers\Api\Logincontroller::class,'logout']);
Route::post('/login', [App\Http\Controllers\Api\Logincontroller::class,'authenticate']);
Route::get('/producto/all',[App\Http\Controllers\Api\ProductoController::class,'all']);
Route::get('/producto/show/{id}',[App\Http\Controllers\Api\ProductoController::class,'show']);
Route::middleware('auth:sanctum')->group(function()
{
    # code...
    Route::get('/permission/all',[App\Http\Controllers\Api\PermissionController::class,'all']);
    Route::get('/role/all',[App\Http\Controllers\Api\RoleController::class,'all']);
    Route::get('/cidade/all',[App\Http\Controllers\Api\CidadeController::class,'all']);
    Route::get('/categoria/all',[App\Http\Controllers\Api\CategoriaController::class,'all']);
    Route::get('/bairro/all',[App\Http\Controllers\Api\BairroController::class,'all']);
    Route::get('/cliente/all',[App\Http\Controllers\Api\ClienteController::class,'all']);
    Route::post('/pedido/novo',[App\Http\Controllers\Api\PedidoController::class,'pedidoNovo']);
    Route::post('/pedido/pos',[App\Http\Controllers\Api\PedidoController::class,'pos']);
    Route::get('/pedido/{pedido_id}',[App\Http\Controllers\Api\PedidoController::class,'factura']);
    Route::get('/pedido/show/{pedido_id}',[App\Http\Controllers\Api\PedidoController::class,'show']);
    Route::get('/pedidos/history',[App\Http\Controllers\Api\PedidoController::class,'history']);
    Route::get('/home',[App\Http\Controllers\Api\HomeController::class,'index']);
    Route::apiResources(['role' => Api\RoleController::class,
                        'permission' => Api\PermissionController::class,
                        'user' => Api\UserController::class,
                        'cidade' => Api\CidadeController::class,
                        'bairro' => Api\BairroController::class,
                        'categoria'=>  Api\CategoriaController::class,
                        'producto' =>    Api\ProductoController::class,
                        'cliente' => Api\ClienteController::class
    ]);
});

