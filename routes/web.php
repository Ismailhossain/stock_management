<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\RequisitionController;
use App\Http\Controllers\StockController;

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
Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('statusCode', [HomeController::class, 'statusCode'])->name('home-statusCode');

Route::group(['prefix' => 'item'], function () {
    Route::get('create', [ItemController::class, 'create'])->name('item-create');
    Route::post('store', [ItemController::class, 'store'])->name('item-store');
    Route::get('show', [ItemController::class, 'show'])->name('item-show');
    Route::post('show', [ItemController::class, 'getItemList'])->name('item-show-json');
    Route::get('edit/{id}', [ItemController::class, 'edit'])->name('item-edit');
    Route::put('update/{id}', [ItemController::class, 'update'])->name('item-update');
    Route::put('delete/{id}', [ItemController::class, 'delete'])->name('item-delete');
});
Route::group(['prefix' => 'supplier'], function () {
    Route::get('create', [SupplierController::class, 'create'])->name('supplier-create');
    Route::post('store', [SupplierController::class, 'store'])->name('supplier-store');
    Route::get('show', [SupplierController::class, 'show'])->name('supplier-show');
    Route::post('show', [SupplierController::class, 'getSupplierList'])->name('supplier-show-json');
    Route::get('edit/{id}', [SupplierController::class, 'edit'])->name('supplier-edit');
    Route::put('update/{id}', [SupplierController::class, 'update'])->name('supplier-update');
    Route::put('delete/{id}', [SupplierController::class, 'delete'])->name('supplier-delete');
});
Route::group(['prefix' => 'stock'], function () {
    Route::get('create', [StockController::class, 'create'])->name('stock-create');
    Route::post('store', [StockController::class, 'store'])->name('stock-store');
    Route::get('show', [StockController::class, 'show'])->name('stock-show');
    Route::post('show', [StockController::class, 'getStockList'])->name('stock-show-json');
    Route::get('edit/{id}', [StockController::class, 'edit'])->name('stock-edit');
    Route::put('update/{id}', [StockController::class, 'update'])->name('stock-update');
    Route::put('delete/{id}', [StockController::class, 'delete'])->name('stock-delete');
});

Route::group(['prefix' => 'requisition'], function () {
    Route::get('create', [RequisitionController::class, 'create'])->name('requisition-create');
    Route::post('store', [RequisitionController::class, 'store'])->name('requisition-store');
    Route::get('show', [RequisitionController::class, 'show'])->name('requisition-show');
    Route::get('edit/{id}', [RequisitionController::class, 'edit'])->name('requisition-edit');
    Route::put('update/{id}', [RequisitionController::class, 'update'])->name('requisition-update');
    Route::put('delete/{id}', [RequisitionController::class, 'delete'])->name('requisition-delete');
    Route::put('delete/{id}', [RequisitionController::class, 'delete'])->name('requisition-delete');
    Route::put('status/{id}', [RequisitionController::class, 'statusUpdate'])->name('requisition-status');
    Route::post('itemQty', [RequisitionController::class, 'getItemQtyByAjax'])->name('requisition-itemQty-ajax');

});








Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
