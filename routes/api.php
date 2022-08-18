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

Route::apiResource('lists', CheckListController::class)->middleware('auth:sanctum');

Route::post('elements/update_checked/{element}', [CheckElementController::class, 'updateChecked'])->name('elements.update_checked')->middleware('auth:sanctum');
Route::resource('elements', CheckElementController::class)->only(['store', 'destroy'])->middleware('auth:sanctum');

Route::post('/register',[AuthController::class,'register']);

Route::post('/login', [AuthController::class, 'login']);

//Auth::routes();
