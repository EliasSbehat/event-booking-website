<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\StripePaymentController;
use Illuminate\Http\Request;


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
Route::controller(MainController::class)->group(function () {
    Route::get('/', 'lists');
    Route::get('/dashboard', 'details');
    Route::get('/bookings', 'bookings');
    Route::get('/settings', 'settings');
    Route::get('/confirmation', 'confirmation');
    Route::get('/pwdset', 'pwdset');
    Route::get('/getpwd', 'getpwd');
    
    

    Route::get('/bookingmng/getBK', 'bookingmngGetBK');
    Route::get('/eventmng/getMS', 'eventGetMS');
    Route::get('/eventmng/getData', 'eventGetData');
    Route::post('/eventmng/add', 'eventAdd');
    Route::get('/eventmng/getForEdit', 'getEvents');
    Route::get('/eventmng/delete-event', 'deleteEvent');


    Route::post('/confirmationmng/saveConfirmation', 'saveConfirmation');
    Route::get('/confirmationmng/getConfirmation', 'getConfirmation');
    
    Route::get('/buy/{event_id}', 'buy');
});


Route::post('create-checkout-session', [StripePaymentController::class, 'stripePostCheckout'])->name('stripe.PostCheckout');
Route::get('success', [StripePaymentController::class, 'success'])->name('stripe.success');
Route::get('cancel', [StripePaymentController::class, 'cancel'])->name('stripe.cancel');
Route::get('test', [StripePaymentController::class, 'test'])->name('stripe.test');
Route::get('test2', [StripePaymentController::class, 'test'])->name('stripe.test');

