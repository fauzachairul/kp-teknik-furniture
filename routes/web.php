<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\User\TxStockOutController;
use App\Http\Controllers\User\UserDashboardController;
use App\Models\BahanBaku;

Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;

        return match ($role) {
            'admin' => redirect('/admin/dashboard'),
            'user'  => redirect('/user/dashboard'),
            default => redirect('/login')
        };
    }

    return redirect('/login');
});

Route::get('/login', function () {
    return view('auth.login', [
        'title' => 'Login Page',
    ]);
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', \App\Http\Middleware\IsAdmin::class])
    ->prefix('admin')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // ---------------------------
        // Units
        // ---------------------------
        Route::get('/units', [UnitController::class, 'index'])->name('admin.units.index');
        Route::get('/units/tambah-satuan', [UnitController::class, 'create'])->name('admin.units.tambah');
        Route::post('/units/tambah-satuan', [UnitController::class, 'store'])->name('units.tambah');
        Route::get('/units/{id}/edit', [UnitController::class, 'edit'])->name('admin.units.edit');
        Route::put('/units/{id}', [UnitController::class, 'update'])->name('units.update');
        Route::delete('/units/{id}', [UnitController::class, 'destroy'])->name('units.hapus');



        //kategori

        Route::get('/categories', [CategoryController::class, 'index'])
            ->name('admin.categories.index');
        Route::get('/categories/tambah-kategori', [CategoryController::class, 'create'])
            ->name('admin.categories.tambah');
        Route::post('/categories/tambah-kategori', [CategoryController::class, 'store'])
            ->name('categories.tambah');
        Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])
            ->name('admin.categories.edit');
        Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])
            ->name('categories.hapus');

        // ---------------------------
        // Raw Materials
        // ---------------------------
        Route::get('/raw-materials', [BahanBakuController::class, 'index'])->name('admin.rawMaterials.index');
        Route::get('/raw-materials/tambah-material', [BahanBakuController::class, 'create'])->name('admin.rawMaterials.tambah');
        Route::post('/raw-materials/tambah-material', [BahanBakuController::class, 'store'])->name('rawMaterial.tambah');
        Route::get('/raw-materials/{id}/edit', [BahanBakuController::class, 'edit'])->name('admin.rawMaterials.edit');
        Route::put('/raw-materials/{id}', [BahanBakuController::class, 'update'])->name('rawMaterial.update');
        Route::delete('/raw-materials/{id}', [BahanBakuController::class, 'destroy'])->name('rawMaterial.hapus');

        // ---------------------------
        // Transaksi Stock
        // ---------------------------
        Route::get('/transaksis-tambah', [StockInController::class, 'indexTambah'])->name('admin.transaksis.index');
        Route::get('/transaksis-tambah/{bahan_baku_kd}/tambah-stock', [StockInController::class, 'createTambah'])->name('admin.transaksis.tambah-stock');
        Route::post('/transaksis-tambah', [StockInController::class, 'storeTambah'])->name('tambah-stock.store');
        Route::get('/transaksis/riwayat', [StockInController::class, 'riwayat'])->name('admin.transaksis.riwayat');


        Route::get('/transaksis/history-out', [StockOutController::class, 'history'])->name('admin.transaksis.history-out');
        Route::get('/transaksis/stock-out/create', [StockOutController::class, 'create'])->name('admin.transaksis.stock-out');
        Route::post('/transaksis/stock-out', [StockOutController::class, 'store'])->name('stock-out.store');
        Route::get('/transaksis/stock-out/{id}', [StockOutController::class, 'show'])->name('stock-out.show');
        Route::get('/transaksi/stock-out/{id}/view-pdf', [StockOutController::class, 'view_pdf'])->name('stock-out-detail.view-pdf');
        Route::get('/transaksi/stock-out/{id}/download-pdf', [StockOutController::class, 'download_pdf'])->name('stock-out-detail.download');


        //project
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('//projects/tambah-project', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/projects/store', [ProjectController::class, 'store'])->name('project.store');
        Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('project.edit');
        Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('project.update');
        Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('project.hapus');

        //users
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/users/{id}/', [UserController::class, 'update'])->name('user.update');


        //laporan
        Route::get('/laporan/raw-materials', [LaporanController::class, 'rawMaterials'])->name('laporan.raw-materials');

        Route::get('/laporan/stock-outs', [LaporanController::class, 'stockOuts'])->name('laporan.stockOuts');

        Route::get('/laporan/stock-ins', [LaporanController::class, 'stockIns'])->name('laporan.stockIns');

        Route::get('/laporan/stock-outs/view-pdf', [LaporanController::class, 'so_view_pdf'])->name('laporan.stockOuts-pdf');

        Route::get('/laporan/stock-ins/view-pdf', [LaporanController::class, 'si_view_pdf'])->name('laporan.stockIns-pdf');

        Route::get('/laporan/raw-materials/view-pdf', [LaporanController::class, 'rm_view_pdf'])->name('laporan.rawMaterials-pdf');
    });



Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('userDashboard');
    Route::get('/raw-materials', [BahanBakuController::class, 'userIndex'])->name('user.rawMaterials.index');
    Route::get('/transaksis', [TxStockOutController::class, 'create'])->name('user.transaksis.create');
    Route::get('/transaksis/history-out', [TxStockOutController::class, 'history'])->name('user.transaksis.history-out');
    Route::post('/transaksis/stock-out', [TxStockOutController::class, 'store'])->name('user.stock-out.store');

    Route::get('/transaksis/stock-out/{id}', [TxStockOutController::class, 'show'])->name('stock-out-detail.show');
});
