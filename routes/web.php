<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckListController;
use App\Http\Controllers\CheckElementController;
use App\Http\Controllers\Admin\UserController;

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

Route::group(['middleware' => ['auth']], function($router) {

    Route::resource('lists', CheckListController::class);

    Route::resource('elements', CheckElementController::class)->only(['store', 'destroy']);
    Route::post('elements/update_checked', [CheckElementController::class, 'updateChecked'])->name('elements.update_checked');

    /*Route::controller(CheckElementController::class)->group(function() {
        //Route::post('elements/store', 'store')->name('elements.store');
    });*/

    Route::group(['middleware' => ['role:admin|moderator|list_limiter|list_reader']], function (){
        Route::resource('users', UserController::class)->only(['index','show']);
    });

    Route::group(['middleware' => ['role:admin']], function (){
        Route::patch('users/{user}/update_roles', [UserController::class, 'updateRoles'])->name('users.update_roles');
    });

    Route::group(['middleware' => ['role:admin|moderator']], function (){
        Route::patch('users/{user}/update_status', [UserController::class, 'updateStatus'])->name('users.update_status');
    });

    Route::group(['middleware' => ['role:admin|list_limiter']], function (){
        Route::patch('users/{user}/update_list_limit', [UserController::class, 'updateListLimit'])->name('users.update_list_limit');
    });

    Route::group(['middleware' => ['role:admin|list_reader']], function (){
        Route::get('admin/lists', [CheckListController::class, 'indexAdministration'])->name('lists.admin_index');
    });
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
