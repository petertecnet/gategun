<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\ProducerApiController;

// Rotas para autenticação
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::match(['get', 'post'], '/check-auth', [AuthController::class, 'checkAuth']);
Route::any('/logout', [AuthController::class, 'logout']);

// Rota protegida por autenticação com Sanctum
Route::middleware('auth:sanctum')->group(function () {
    // Rota para refresh do token
    Route::post('/refresh', [AuthController::class, 'refresh']);
    // Rota para obter informações do usuário autenticado
    Route::get('/user', [AuthController::class, 'user']);
    
    // Rotas para API do ProducerController usando apiResource
    
});
