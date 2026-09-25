<?php

use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

// System & SEO routes
Route::get('/health', HealthCheckController::class)->name('health');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{portfolio:slug}', [PortfolioController::class, 'show'])->name('portfolio.show');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:contact')->name('contact.store');

// Auth routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:login');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->middleware('throttle:register');

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->middleware('throttle:password-reset')->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->middleware('throttle:password-reset')->name('password.update');
});

use App\Http\Controllers\ProfileController;

// Authenticated Client Dashboard routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/dashboard/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/dashboard/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    Route::get('/dashboard/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/dashboard/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/dashboard/orders', [OrderController::class, 'store'])->middleware('throttle:10,1')->name('orders.store');
    Route::get('/dashboard/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/dashboard/orders/{order}/attachments/{attachment}', [OrderController::class, 'downloadAttachment'])->name('orders.attachments.download');

    Route::get('/dashboard/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/dashboard/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/dashboard/tickets', [TicketController::class, 'store'])->middleware('throttle:10,1')->name('tickets.store');
    Route::get('/dashboard/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('/dashboard/tickets/{ticket}/reply', [TicketController::class, 'reply'])->middleware('throttle:20,1')->name('tickets.reply');
});

// Admin Panel routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->middleware('throttle:sensitive-admin')->name('admin.users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->middleware('throttle:sensitive-admin')->name('admin.users.destroy');

    Route::resource('services', AdminServiceController::class)->names('admin.services');
    Route::resource('portfolios', AdminPortfolioController::class)->names('admin.portfolios');

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->middleware('throttle:sensitive-admin')->name('admin.orders.destroy');

    Route::get('/tickets', [AdminTicketController::class, 'index'])->name('admin.tickets.index');
    Route::get('/tickets/{ticket}', [AdminTicketController::class, 'show'])->name('admin.tickets.show');
    Route::post('/tickets/{ticket}/reply', [AdminTicketController::class, 'reply'])->name('admin.tickets.reply');
    Route::put('/tickets/{ticket}/status', [AdminTicketController::class, 'updateStatus'])->name('admin.tickets.updateStatus');
    Route::delete('/tickets/{ticket}', [AdminTicketController::class, 'destroy'])->middleware('throttle:sensitive-admin')->name('admin.tickets.destroy');

    Route::get('/contacts', [AdminContactController::class, 'index'])->name('admin.contacts.index');
    Route::get('/contacts/{contact}', [AdminContactController::class, 'show'])->name('admin.contacts.show');
    Route::delete('/contacts/{contact}', [AdminContactController::class, 'destroy'])->middleware('throttle:sensitive-admin')->name('admin.contacts.destroy');
});
