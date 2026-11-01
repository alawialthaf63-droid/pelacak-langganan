<?php

use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/subscriptions');

Route::get('/subscriptions', [SubscriptionController::class, 'index'])
    ->name('subscriptions.index');
Route::post('/subscriptions', [SubscriptionController::class, 'store'])
    ->name('subscriptions.store');
Route::get('/subscriptions/{subscription}/edit', [SubscriptionController::class, 'edit'])
    ->name('subscriptions.edit');
Route::put('/subscriptions/{subscription}', [SubscriptionController::class, 'update'])
    ->name('subscriptions.update');
Route::delete('/subscriptions/{subscription}', [SubscriptionController::class, 'destroy'])
    ->name('subscriptions.destroy');