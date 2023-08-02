<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{ProductionController, EventController, TicketController, CartController, ItemController, };

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rotas para exibir a lista de eventos e criar um novo evento
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
Route::post('/events/add', [EventController::class, 'store'])->name('events.store');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
Route::post('/events/storeFeedback/{event}', [EventController::class, 'storeFeedback'])->name('events.storeFeedback');
Route::post('/events/{eventId}/storeComment', [EventController::class, 'storeComment'])->name('events.storeComment');
Route::post('/events/{eventId}/comments', [EventController::class, 'storeComment'])->name('events.storeComment');
Route::get('/events/{eventId}/getComments', [EventController::class, 'getComments'])->name('events.getComments');



// Rotas para o CRUD do ticket
Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
Route::post('/tickets/payment', [TicketController::class, 'payment'])->name('tickets.payment');
Route::get('/tickets/checkPaymentStatus/{idorder}', [TicketController::class, 'checkPaymentStatus'])->name('tickets.checkPaymentStatus');
Route::get('/tickets/myOne/{id}', [TicketController::class, 'myOne'])->name('tickets.myOne');
Route::post('/tickets/capture/{id}', [TicketController::class, 'captureTicket'])->name('tickets.capture');
Route::get('/tickets/detail/{id}', [TicketController::class, 'detail'])->name('tickets.detail');
Route::get('/tickets/checkValidationStatus/{id}', [TicketController::class, 'checkValidation'])->name('tickets.checkValidationStatus');


Route::get('/productions/all', [ProductionController::class, 'index'])->name('productions.index');
Route::get('/productions/create', [ProductionController::class, 'create'])->name('productions.create');
Route::post('/productions/store', [ProductionController::class, 'store'])->name('productions.store');
Route::get('/productions/{production}', [ProductionController::class, 'show'])->name('productions.show');
Route::get('/productions/{production}/edit', [ProductionController::class, 'edit'])->name('productions.edit');
Route::put('/productions/{production}', [ProductionController::class, 'update'])->name('productions.update');
Route::delete('/productions/{production}', [ProductionController::class, 'destroy'])->name('productions.destroy');
Route::get('/productions/register-entry/{id}', [ProductionController::class, 'registerEntry'])->name('productions.registerEntry');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/cart/add', [CartController::class, 'addItemToCart'])->name('cart.add');
Route::get('/cart/viewCart', [CartController::class, 'viewCart'])->name('cart.viewCart');
Route::get('/cart/generateQRCode', [CartController::class, 'generateQRCode'])->name('cart.generateQRCode');
Route::get('/cart/checkPaymentStatus/{idorder}', [CartController::class, 'checkPaymentStatus'])->name('cart.checkPaymentStatus');



// Rotas para o ItemController
Route::get('/items', [ItemController::class, 'index']); // Listar todos os itens
Route::get('/items/{id}', [ItemController::class, 'show']); // Mostrar um item específico
Route::post('/items', [ItemController::class, 'store']); // Criar um novo item
Route::put('/items/{id}', [ItemController::class, 'update']); // Atualizar um item existente
Route::delete('/items/{id}', [ItemController::class, 'destroy']); // Excluir um item


// Exibir formulário de feedback e avaliação
Route::get('/events/{eventId}/feedback', 'FeedbackController@showFeedbackForm')->name('feedback.form');
// Armazenar feedback e avaliação
Route::post('/feedback', 'FeedbackController@storeFeedback')->name('feedback.store');