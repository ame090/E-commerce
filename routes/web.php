<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminTicketController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminCustomerController;
use App\Http\Controllers\Seller\SellerDashboardController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerOrderController;
use App\Http\Controllers\Seller\SellerProductImageController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Auth Routes (Breeze)
require __DIR__.'/auth.php';

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    // Payment
    Route::get('/payment/{order}', [PaymentController::class, 'index'])->name('payment.index');
    Route::post('/payment/{order}/create', [PaymentController::class, 'create'])->name('payment.create');
    Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
    Route::post('/payment/callback', [PaymentController::class, 'callback']);

    // Reviews
    Route::get('/orders/{order}/products/{product}/review', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/orders/{order}/products/{product}/review', [ReviewController::class, 'store'])->name('reviews.store');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Tickets
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');

    // Chat/Messages
    Route::get('/messages', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/messages/{user}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/messages/{user}', [ChatController::class, 'store'])->name('chat.send');
    Route::get('/contact-seller/{product}', [ChatController::class, 'contactSeller'])->name('chat.contact');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Users
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
    
    // Sellers
    Route::get('/sellers', [AdminUserController::class, 'sellers'])->name('sellers.index');
    Route::post('/sellers/{seller}/approve', [AdminUserController::class, 'approveSeller'])->name('sellers.approve');
    Route::post('/sellers/{seller}/reject', [AdminUserController::class, 'rejectSeller'])->name('sellers.reject');
    
    // Customers
    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{customer}', [AdminCustomerController::class, 'show'])->name('customers.show');
    Route::post('/customers/{customer}/toggle-status', [AdminCustomerController::class, 'toggleStatus'])->name('customers.toggle-status');
    
    // Products
    Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
    Route::post('/products/{product}/approve', [AdminProductController::class, 'approve'])->name('products.approve');
    Route::post('/products/{product}/reject', [AdminProductController::class, 'reject'])->name('products.reject');
    Route::post('/products/{product}/toggle-featured', [AdminProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    
    // Categories
    Route::resource('categories', AdminCategoryController::class);
    
    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Tickets
    Route::get('/tickets', [AdminTicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [AdminTicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/reply', [AdminTicketController::class, 'reply'])->name('tickets.reply');
    Route::post('/tickets/{ticket}/status', [AdminTicketController::class, 'updateStatus'])->name('tickets.update-status');
    
    // Reports
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
});

// Seller Routes
Route::middleware(['auth'])->prefix('seller')->name('seller.')->group(function () {
    // Registration
    Route::get('/register', [SellerDashboardController::class, 'register'])->name('register');
    Route::post('/register', [SellerDashboardController::class, 'storeRegistration'])->name('register.store');
    Route::get('/pending', function () {
        return view('seller.pending');
    })->name('pending');
});

Route::middleware(['auth', 'seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');
    
    // Products
    Route::get('/products', [SellerProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [SellerProductController::class, 'create'])->name('products.create');
    Route::post('/products', [SellerProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [SellerProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [SellerProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [SellerProductController::class, 'destroy'])->name('products.destroy');
    Route::delete('/products/{product}/image', [SellerProductImageController::class, 'destroy'])->name('products.image.delete');
    
    // Orders
    Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [SellerOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/status', [SellerOrderController::class, 'updateStatus'])->name('orders.update-status');
});

// Customer Dashboard
Route::middleware(['auth'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
});

// Redirect based on role after login
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isSeller()) {
        return redirect()->route('seller.dashboard');
    } else {
        return redirect()->route('customer.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');
