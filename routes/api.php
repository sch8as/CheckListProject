<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CheckListController;
use App\Http\Controllers\Api\CheckElementController;
use App\Http\Controllers\Api\AuthController;
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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['middleware' => ['auth:sanctum']], function($router) {

    //Lists
    Route::apiResource('lists', CheckListController::class);

    //Elements
    Route::post('elements/update_checked/{element}', [CheckElementController::class, 'updateChecked'])->name('elements.update_checked');
    Route::resource('elements', CheckElementController::class)->only(['store', 'destroy']);
});

Route::post('/register',[AuthController::class,'register']);
Route::post('/login', [AuthController::class, 'login'])->middleware('api_login');
