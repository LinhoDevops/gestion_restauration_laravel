<?php

use App\Http\Controllers\ClientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StatsController;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Illuminate\Support\Facades\Auth;


// Routes publiques pour l'authentification
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes proteger par sanctum
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Routes pour les produits
    Route::middleware(['role:gestionnaire'])->group(function () {
        Route::get('/products', [ProductController::class, 'index']);
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{id}', [ProductController::class, 'update']);
        Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    });

    // Routes pour les commandes
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/client/orders', [ClientController::class, 'myOrders'])->name('client.orders')->middleware('auth');
    Route::get('/orders', [OrderController::class, 'index'])->middleware('role:gestionnaire');
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::put('/orders/{id}', [OrderController::class, 'update'])->middleware('role:gestionnaire');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->middleware('role:gestionnaire');

    // Routes pour les paiements (gestionnaire uniquement)
    Route::middleware(['role:gestionnaire'])->group(function () {
        Route::post('/payments', [PaymentController::class, 'store']);
        Route::get('/payments', [PaymentController::class, 'index']);
    });

    // Routes pour les statistiques (gestionnaire uniquement)
    Route::middleware(['role:gestionnaire'])->group(function () {
        Route::get('/stats/orders/daily', [StatsController::class, 'dailyOrders']);
        Route::get('/stats/orders/monthly', [StatsController::class, 'monthlyOrders']);
        Route::get('/stats/revenue/daily', [StatsController::class, 'dailyRevenue']);
        Route::get('/stats/revenue/monthly', [StatsController::class, 'monthlyRevenue']);
    });

    // Routes pour les notifications
    Route::get('/notifications', function () {
        return response()->json(Auth::user()->notifications);
    });

    Route::post('/notifications/read', function () {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['message' => 'Notifications marquées comme lues']);
    });
});
