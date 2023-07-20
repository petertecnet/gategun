<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ProductionController, EventController, TicketController};

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rotas para exibir a lista de eventos e criar um novo evento
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
Route::post('/events', [EventController::class, 'store'])->name('events.store');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

// Rotas para o CRUD do ticket
Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');


Route::get('/productions', [ProductionController::class, 'index'])->name('productions.index');
Route::get('/productions/create', [ProductionController::class, 'create'])->name('productions.create');
Route::post('/productions', [ProductionController::class, 'store'])->name('productions.store');
Route::get('/productions/{production}', [ProductionController::class, 'show'])->name('productions.show');
Route::get('/productions/{production}/edit', [ProductionController::class, 'edit'])->name('productions.edit');
Route::put('/productions/{production}', [ProductionController::class, 'update'])->name('productions.update');
Route::delete('/productions/{production}', [ProductionController::class, 'destroy'])->name('productions.destroy');
