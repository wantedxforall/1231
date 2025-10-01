<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Front\StoresController;
use App\Http\Controllers\Front\InvoicesController;
use App\Http\Controllers\Admin\ProvidersController;

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

Route::get('stores/payment_link_check', [StoresController::class, 'payment_link_check'])->name('api.stores.payment_link_check');
Route::get('payment_link_check', [StoresController::class, 'payment_link_check'])->name('api.stores.payment_link_check');

Route::get('stores/payment_info/{store}', [StoresController::class, 'payment_info'])->name('api.stores.payment_info');
Route::get('getPaymentInfo', [StoresController::class, 'getPaymentInfo'])->name('api.getPaymentInfo');
Route::get('invoices/invoices_check', [InvoicesController::class, 'invoices_check'])->name('api.invoices.invoices_check');

Route::middleware('token')->group(function () {
    Route::post('/check_token', [StoresController::class, 'check_token'])->name('api.check_token');
    Route::post('/send_message', [StoresController::class, 'send_message'])->name('api.send_message');
    Route::post('/device_update', [StoresController::class, 'device_update'])->name('api.device_update');
});
