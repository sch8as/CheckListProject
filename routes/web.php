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

    Route::get('/lists', [CheckListController::class, 'index'])->name('lists_index');
    Route::get('lists/create', [CheckListController::class, 'create'])->name('lists_create');
    Route::post('lists/store', [CheckListController::class, 'store'])->name('lists_store');
    Route::get('lists/edit/{id}', [CheckListController::class, 'edit'])->name('lists_edit');
    Route::patch('lists/update/{id}', [CheckListController::class, 'update'])->name('lists_update');
    Route::get('lists/delete/{id}', [CheckListController::class, 'destroy'])->name('lists_delete');


    Route::get('elements/{list_id}',[CheckElementController::class, 'index']);
    Route::post('elements/store', [CheckElementController::class, 'store'])->name('elements_store');
    /*Route::post('elements/set_check', [CheckElementController::class, 'set_check'])->name('elements_set_check');*/
    Route::get('elements/delete/{id}', [CheckElementController::class, 'destroy'])->name('elements_delete');
    /*Route::post('elements/test', [CheckElementController::class, 'test'])->name('test');*/
    Route::post('elements/update_checked', [CheckElementController::class, 'update_checked'])->name('elements_update_checked');
});

Route::group(['middleware' => ['role:admin|moderator|list_limiter|list_reader']], function (){
    Route::get('users', [UserController::class, 'index'])->name('users_index');
    Route::get('users/show/{id}', [UserController::class, 'show'])->name('users_show');

});

Route::group(['middleware' => ['role:admin']], function (){
    Route::patch('users/update_roles/{id}', [UserController::class, 'update_roles'])->name('users_update_roles');
});

Route::group(['middleware' => ['role:admin|moderator']], function (){
    Route::patch('users/update_status/{id}', [UserController::class, 'update_status'])->name('users_update_status');
});

Route::group(['middleware' => ['role:admin|list_limiter']], function (){
    Route::patch('users/update_list_limit/{id}', [UserController::class, 'update_list_limit'])->name('users_update_list_limit');
});

Route::group(['middleware' => ['role:admin|list_reader']], function (){
    Route::get('admin/lists', [CheckListController::class, 'index_administration'])->name('admin_lists_index');
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
