<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Admin\PlansController;
use App\Http\Controllers\Front\StaffController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Front\StoresController;
use App\Http\Controllers\Front\PricingController;
use App\Http\Controllers\Front\ProfileController;
use App\Http\Controllers\Front\InvoicesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProvidersController;
use App\Http\Controllers\Front\TransactionsController;

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

// Front Routes
//['as' => 'front.', 'middleware' => ['auth', 'language']],
Route::middleware(['auth', 'language'])->as('front.')->group(function () {
    Route::post('resend-own-email-virefication', [HomeController::class, 'resendOwnEmailVirefication'])->name('resend-own-email-virefication');
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('profile', [ProfileController::class, 'changePasswordPost'])->name('profile.password.post');

    Route::get('transactions', [TransactionsController::class, 'index'])->name('transactions');
    Route::post('transactions/export/{storeId?}', [TransactionsController::class, 'export'])->name('transactions.export');
    Route::post('transactions/store', [TransactionsController::class, 'store'])->name('transactions.store');
    Route::post('transactions/{transaction}/approve', [TransactionsController::class, 'approve'])->name('transactions.approve');
    Route::post('transactions/{transaction}/reject', [TransactionsController::class, 'reject'])->name('transactions.reject');
    Route::post('transactions/{transaction}/resend', [TransactionsController::class, 'resend'])->name('transactions.resend');
    Route::delete('transactions/{transaction}/destroy', [TransactionsController::class, 'destroy'])->name('transactions.destroy');

    // Route::get('pricing', [PricingController::class, 'index'])->name('pricing');

    // Route::resource('invoices', InvoicesController::class);
    Route::get('invoices', [InvoicesController::class, 'index'])->name('invoices.index');
    Route::get('invoices/{hash}', [InvoicesController::class, 'show'])->name('invoices.show');
    Route::post('invoices/{invoice}/approve', [InvoicesController::class, 'approve'])->name('invoices.approve');
    Route::post('invoices/{invoice}/cancel', [InvoicesController::class, 'cancel'])->name('invoices.cancel');
    Route::post('invoices/{invoice}/payment', [InvoicesController::class, 'payment'])->name('invoices.payment');
    Route::get('/payments/verify/{payment?}',[InvoicesController::class,'payment_verify'])->name('payment-verify');


    // Stores Routes
    Route::get('stores', [StoresController::class, 'index'])->name('stores');
    Route::get('stores/create', [StoresController::class, 'create'])->name('stores.create');
    Route::post('stores/save', [StoresController::class, 'save_store'])->name('stores.save');
    Route::get('stores/{store}/transactions', [StoresController::class, 'transactions'])->name('stores.transactions');
    Route::get('stores/{store}/qrcode', [StoresController::class, 'qrcode'])->name('stores.qrcode');
    Route::get('stores/{store}/integration', [StoresController::class, 'integration'])->name('stores.integration');
    Route::get('stores/edit/{id}', [StoresController::class, 'edit'])->name('stores.edit');
    Route::post('stores/update/{id}', [StoresController::class, 'update'])->name('stores.update');
    // Route::get('stores/message',[StoresController::class,'messages'])->name('store.message');

    // End Stors
    Route::get('staff', [StaffController::class, 'index'])->name('staff');
});

Route::get('404', [HomeController::class, 'not_found'])->name('front.layouts.404');

Route::get('invoices/{hash}', [InvoicesController::class, 'show'])->name('front.invoices.show');
Route::get('/payments/verify/{payment?}',[InvoicesController::class,'payment_verify'])->name('payment-verify');

Route::get('store/{username}', [StoresController::class, 'payment_link'])->name('front.stores.payment_link');
Route::get('stores/payment_link_check', [StoresController::class, 'payment_link_check'])->name('front.stores.payment_link_check');

Route::group(['prefix' => 'dashboard', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('options', OptionController::class)->only(['index', 'store']);
    Route::resource('users', UserController::class);
    Route::post('users/{user}/login-as-user', [UserController::class, 'loginAsUser'])->name('users.login');

    Route::post('users/{user}/emailVerfiy', [UserController::class, 'verfiy'])->name('users.verfiy');
    // Route::resource('providers', ProvidersController::class);
    Route::resource('plans', PlansController::class);
    Route::get('stores', [\App\Http\Controllers\Admin\StoresController::class, 'index'])->name('stores');
    Route::get('stores/destroy/{id}', [\App\Http\Controllers\Admin\StoresController::class, 'destroy'])->name('stores.destroy');
    Route::get('stores/edit/{id}', [\App\Http\Controllers\Admin\StoresController::class, 'edit'])->name('stores.edit');
    Route::post('stores/update/{id}', [\App\Http\Controllers\Admin\StoresController::class, 'update'])->name('stores.update');
    Route::get('stores/{store}/transactions', [\App\Http\Controllers\Admin\StoresController::class, 'transactions'])->name('stores.transactions');
    Route::resource('invoices', \App\Http\Controllers\Admin\InvoicesController::class);
    Route::resource('payments', \App\Http\Controllers\Admin\PaymentsController::class);

});

Route::get('locale/{locale}', [HomeController::class, 'setLocale'])->name('locale');


require __DIR__ . '/auth.php';
