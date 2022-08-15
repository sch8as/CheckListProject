<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckListController;
use App\Http\Controllers\CheckElementController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CheckListController as AdminCheckListController;

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

    //Lists
    Route::resource('lists', CheckListController::class);

    //Elements
    Route::post('elements/update_checked', [CheckElementController::class, 'updateChecked'])->name('elements.update_checked');
    Route::resource('elements', CheckElementController::class)->only(['store', 'destroy']);


    Route::name('admin.')->group(function () {

        //Admin users
        Route::controller(AdminUserController::class)->group(function () {
            Route::group(['middleware' => ['role:admin']], function () {
                Route::patch('admin/users/{user}/update_roles', 'updateRoles')->name('users.update_roles');
            });

            Route::group(['middleware' => ['role:admin|moderator']], function () {
                Route::patch('admin/users/{user}/update_status', 'updateStatus')->name('users.update_status');
            });

            Route::group(['middleware' => ['role:admin|list_limiter']], function () {
                Route::patch('admin/users/{user}/update_list_limit', 'updateListLimit')->name('users.update_list_limit');
            });

            Route::group(['middleware' => ['role:admin|moderator|list_limiter|list_reader']], function () {
                Route::resource('admin/users', AdminUserController::class)->only(['index', 'show']);
            });
        });

        //Admin lists
        Route::group(['middleware' => ['role:admin|list_reader']], function () {
            //Route::get('admin/lists', [AdminCheckListController::class, 'index'])->name('lists.index');
            Route::resource('admin/lists', AdminCheckListController::class)->only(['index']);
        });
    });
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
