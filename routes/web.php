<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

// Page d'accueil avec menu intégré
Route::get('/', [HomeController::class, 'index'])->name('home');

// Détail d'un produit (accessible sans authentification)
Route::get('/products/{id}', [ClientController::class, 'productDetail'])->name('product.show');

// Routes d'authentification
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Déconnexion (déplacé en dehors du middleware auth)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes qui nécessitent une authentification
Route::middleware('auth')->group(function () {
    // Routes pour les clients
    Route::middleware('role:client')->prefix('client')->name('client.')->group(function () {
        // Catalogue de produits
        Route::get('/catalog', [ClientController::class, 'catalog'])->name('catalog');

        // Détail d'un produit
        Route::get('/products/{id}', [ClientController::class, 'productDetail'])->name('product.show');

        // Panier
        Route::get('/cart', [CartController::class, 'show'])->name('cart');
        Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
        Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
        Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

        // Commandes
        Route::get('/orders', [ClientController::class, 'myOrders'])->name('orders');
        Route::get('/client/orders', [ClientController::class, 'myOrders'])->name('client.orders')->middleware('auth');
        Route::get('/orders/{id}', [ClientController::class, 'orderDetail'])->name('order.show');
        Route::post('/orders', [OrderController::class, 'store'])->name('order.store');
    });

    // Routes pour les gestionnaires
    Route::middleware('role:gestionnaire')->prefix('gestionnaire')->name('gestionnaire.')->group(function () {
        // Dashboard
        Route::get('/dashboard', function () {
            return view('gestionnaire.dashboard');
        })->name('dashboard');

        // Gestion des produits
        Route::get('/products', [ProductController::class, 'index'])->middleware('role:gestionnaire');
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', function () {
            return view('gestionnaire.products.create');
        })->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}/edit', function ($id) {
            $product = \App\Models\Product::findOrFail($id);
            return view('gestionnaire.products.edit', compact('product'));
        })->name('products.edit');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

        // Gestion des commandes
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{id}', [OrderController::class, 'updateStatus'])->name('orders.update-status');

        // Gestion des paiements
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');

        // Statistiques
        Route::get('/stats', function () {
            return view('gestionnaire.stats.index');
        })->name('stats.index');
        Route::get('/stats/orders/daily', [StatsController::class, 'dailyOrders'])->name('stats.orders.daily');
        Route::get('/stats/orders/monthly', [StatsController::class, 'monthlyOrders'])->name('stats.orders.monthly');
        Route::get('/stats/revenue/daily', [StatsController::class, 'dailyRevenue'])->name('stats.revenue.daily');
        Route::get('/stats/revenue/monthly', [StatsController::class, 'monthlyRevenue'])->name('stats.revenue.monthly');

        // Notifications
        Route::get('/notifications', function () {
            return response()->json(Auth::user()->notifications);
        })->name('notifications');

        Route::post('/notifications/read', function () {
            Auth::user()->unreadNotifications->markAsRead();
            return response()->json(['message' => 'Notifications marquées comme lues']);
        })->name('notifications.read');
    });
});

// Route pour tester la génération de PDF
Route::get('/test-pdf', function () {
    $data = ['title' => 'ISI BURGER'];
    $pdf = PDF::loadView('pdf.test', $data);
    return $pdf->stream('test.pdf');
});
