<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WidgetController;
use App\Http\Controllers\Api\Dashboard\TicketController;
use App\Http\Controllers\Api\TicketController as ApiTicketController;

Route::get('/widget/ticket', [WidgetController::class, 'form']);

Route::post('api/tickets', [ApiTicketController::class, 'store'])->middleware('throttle:widget-ticket');

Route::middleware(['auth:sanctum', 'role:admin|manager'])
    ->group(function () {
        Route::get('api/dashboard/tickets', [TicketController::class, 'index']);
        Route::get('api/dashboard/tickets/{ticket}', [TicketController::class, 'show']);
        Route::patch('api/dashboard/tickets/{ticket}/status', [TicketController::class, 'updateStatus']);
    });

Route::middleware(['auth', 'role:admin|manager'])->group(function () {

    Route::get('/dashboard/tickets', function () {
        return view('dashboard.tickets');
    });

    Route::get('/dashboard/tickets/{id}', function ($id) {
        return view('dashboard.ticket-show', compact('id'));
    });

});
