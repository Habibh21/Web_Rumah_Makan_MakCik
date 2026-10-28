<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;     
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\PosController;       // PEMANGGIL UTAMA MODUL KASIR
use App\Http\Middleware\EnsureUserIsAdmin;    // PENGUNCI KEAMANAN MULTI-USER

/*
|--------------------------------------------------------------------------
| Web Routes - Rumah Makan MAK CIK
|--------------------------------------------------------------------------
*/

// ========================================================
// RUTE PUBLIK SISI PELANGGAN
// ========================================================
Route::get('/', function () { 
    $menus = \App\Models\Menu::orderBy('id', 'desc')->get();
    return view('pelanggan.welcome', compact('menus')); 
})->name('home');

// HALAMAN KHUSUS RESERVASI & TATA CARA WA PELANGGAN
Route::get('/reservasi', [ReservasiController::class, 'index'])->name('reservasi.index');
Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');


// ========================================================
// RUTE AUTENTIKASI KASIR & ADMIN (Login & Logout)
// ========================================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ========================================================
// GERBANG DILEMA: OTOMATISASI ALUR MASUK SETELAH LOGIN
// ========================================================
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.menu_list');
        }
        return redirect()->route('pos.index');
    })->name('admin.index');
});


// ========================================================
// ZONA OPERASIONAL UTAMA (SHARED KASIR & ADMIN ACCESS)
// ========================================================
Route::middleware(['auth'])->group(function () {
    
    // LAYAR KASIR PoS TUNAI & PENCETAKAN STRUK
    Route::get('/kasir/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/kasir/pos/transaksi', [PosController::class, 'store'])->name('pos.store');
    Route::get('/kasir/pos/print/{id}', [PosController::class, 'printReceipt'])->name('pos.print');
    
    // RUTE PEMBATALAN TRANSAKSI (AUDIT LOG VOID)
    Route::post('/kasir/pos/void/{id}', [PosController::class, 'voidOrder'])->name('pos.void');

    // OPERASIONAL KASIR: MANAJEMEN KONTROL MEJA RESTORAN
    Route::get('/kasir/meja', [AdminController::class, 'manajemenMeja'])->name('kasir.meja');
    Route::post('/kasir/meja/kosongkan/{table_number}', [AdminController::class, 'kosongkanMeja'])->name('kasir.meja.kosongkan');
    Route::post('/kasir/meja/pindahkan/{id}', [AdminController::class, 'pindahkanMeja'])->name('kasir.meja.pindahkan');

    // OPERASIONAL KASIR: MONITOR BUKU RESERVASI PELANGGAN VIA WA
    Route::get('/kasir/reservasi', [AdminController::class, 'daftarReservasi'])->name('kasir.reservasi');
    Route::post('/kasir/reservasi/destroy/{id}', [AdminController::class, 'destroyReservasi'])->name('kasir.reservasi.destroy');
});


// ========================================================
// ZONA EKSKLUSIF MANAJEMEN: ADMIN PANEL ONLY
// ========================================================
Route::middleware(['auth', EnsureUserIsAdmin::class])->group(function () {

    // TABEL MANAJEMEN DATA MASTER KELOLA & TAMBAH MENU
    Route::get('/admin/menu-list', [AdminController::class, 'index'])->name('admin.menu_list');
    Route::get('/admin/menu/tambah', [AdminController::class, 'create'])->name('admin.menu_create'); 
    Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.menu_store');
    Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.menu_edit');
    Route::post('/admin/update/{id}', [AdminController::class, 'update'])->name('admin.menu_update');
    Route::post('/admin/destroy/{id}', [AdminController::class, 'destroy'])->name('admin.menu_destroy');
    Route::post('/admin/menu/update-stok/{id}', [AdminController::class, 'updateStok'])->name('admin.menu_update_stok');

    // MODUL ANALISIS E-CRM LOYALITAS PELANGGAN & WA BLAST MARKETING TARGET
    Route::get('/admin/crm', [AdminController::class, 'indexCrm'])->name('admin.crm');

    // MODUL AKUNTANSI LAPORAN OMZET KEUANGAN & SORTING WAKTU
    Route::get('/admin/laporan', [AdminController::class, 'laporanPenghasilan'])->name('admin.laporan');

    // UNDUH LAPORAN OMZET FORMAT EXCEL & CETAK PDF DOKUMEN RESMI
    Route::get('/admin/laporan/excel', [AdminController::class, 'exportCsv'])->name('admin.laporan.excel');
    Route::get('/admin/laporan/pdf', [AdminController::class, 'printPdf'])->name('admin.laporan.pdf');
    Route::get('/admin/audit-log', [AdminController::class, 'auditLog'])->name('admin.audit_log');
});