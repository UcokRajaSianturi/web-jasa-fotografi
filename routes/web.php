<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderCrudController as AdminOrderCrudController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\ServiceCrudController as AdminServiceCrudController;
use App\Http\Controllers\Admin\UserCrudController as AdminUserCrudController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserOrderController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/layanan', [ServiceController::class, 'index'])->name('services.index');
Route::get('/layanan/{slug}', [ServiceController::class, 'show'])->name('services.show');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Customer Protected Routes
Route::middleware('auth')->group(function () {
    // Booking flow
    Route::get('/pesan/{slug?}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/pesan', [BookingController::class, 'store'])->name('bookings.store');

    // Payment Gateway & Transactions
    Route::get('/pembayaran/{order}', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/pembayaran/{order}/proses', [PaymentController::class, 'process'])->name('payments.process');
    Route::post('/pembayaran/{order}/ubah-metode', [PaymentController::class, 'changeMethod'])->name('payments.changeMethod');

    // Invoices
    Route::get('/invoice/{order}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/invoice/{order}/cetak', [InvoiceController::class, 'print'])->name('invoices.print');

    // User Orders History
    Route::get('/pesanan-saya', [UserOrderController::class, 'index'])->name('user.orders.index');
    Route::get('/pesanan-saya/{order}', [UserOrderController::class, 'show'])->name('user.orders.show');
    Route::post('/pesanan-saya/{order}/batal', [UserOrderController::class, 'cancel'])->name('user.orders.cancel');
});

// Admin Protected Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', fn() => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // CRUD Services (Layanan & Paket)
    Route::resource('services', AdminServiceCrudController::class);
    Route::patch('services/{service}/toggle-status', [AdminServiceCrudController::class, 'toggleStatus'])->name('services.toggle');

    // CRUD Orders (Manajemen Pesanan)
    Route::get('orders', [AdminOrderCrudController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderCrudController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [AdminOrderCrudController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::put('orders/{order}', [AdminOrderCrudController::class, 'update'])->name('orders.update');
    Route::delete('orders/{order}', [AdminOrderCrudController::class, 'destroy'])->name('orders.destroy');

    // CRUD Users (Manajemen Pengguna)
    Route::resource('users', AdminUserCrudController::class);

    // Laporan Keuangan (Financial Report, Filter, Excel Export, Print PDF)
    Route::get('laporan-keuangan', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('laporan-keuangan/ekspor-excel', [AdminReportController::class, 'exportCsv'])->name('reports.export');
    Route::get('laporan-keuangan/cetak-pdf', [AdminReportController::class, 'printPdf'])->name('reports.print');
});
