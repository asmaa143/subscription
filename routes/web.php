<?php

use App\Http\Controllers\BillingControlle;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware(['auth','nonPayingCustomer'])->group(function () {
    Route::get('subscribe',[BillingControlle::class,'index'])->name('subscribe');
    Route::post('subscribe',[BillingControlle::class,'store'])->name('subscribe.post');


//    Route::get('checkout/{plan_id}',[CheckoutController::class,'checkout'])->name('checkout');

});

Route::middleware(['auth','payingCustomer'])->group(function () {
    Route::get('members',[BillingControlle::class,'members'])->name('members');
});
Route::middleware(['auth'])->group(function () {
    Route::get('charge',[BillingControlle::class,'charge'])->name('charge');
    Route::post('charge',[BillingControlle::class,'charge_store'])->name('charge.post');
});

Route::post('stripe/webhook',[\App\Http\Controllers\WebhookController::class,'handleWebhook']);

//Route::stripeWebhooks('strip-webhook');

Route::get('admin/home', [HomeController::class, 'adminHome'])->name('admin.home')->middleware('is_admin');
