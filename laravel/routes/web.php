<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WidgetController;
use App\Http\Controllers\Api\WidgetController as ApiWidgetController;

Route::get('/widget/ticket', [WidgetController::class, 'form']);
Route::post('/widget/tickets', [ApiWidgetController::class, 'store'])->middleware('throttle:widget-ticket');

Route::get('/', function () {
    return view('welcome');
});
