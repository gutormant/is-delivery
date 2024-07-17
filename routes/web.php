<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\TestReceiverController;

Route::post('/send',  DeliveryController::class . '@send');
//Route::get('/',  DeliveryController::class . '@error')->name('validation-error');
Route::post('/nova-post-receiver',  TestReceiverController::class . '@receive');
