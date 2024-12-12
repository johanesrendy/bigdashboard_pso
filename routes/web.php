<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route default untuk halaman utama
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rute untuk menampilkan daftar kontak
Route::get('/beranda', [ContactController::class, 'index'])->name('contacts.index'); // Daftar kontak di beranda

// Tracker dan Leads
Route::get('/tracker', [ContactController::class, 'tracker'])->name('data.tracker');
Route::get('/leads', [ContactController::class, 'leads'])->name('data.leads');

// Menampilkan formulir untuk menambahkan kontak baru
Route::get('/contacts/form', [ContactController::class, 'form'])->name('contacts.form');

// Import Kontak
Route::get('/contacts/import', [ContactController::class, 'import'])->name('contacts.import');
Route::post('/contacts/import', [ContactController::class, 'importPost'])->name('contacts.import.post');

// Export data leads
Route::get('/contacts/export', [ContactController::class, 'export'])->name('contacts.export');
Route::post('/contacts/export', [ContactController::class, 'exportData'])->name('contacts.exportData');

// CRUD Kontak
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store'); // Menyimpan kontak baru
Route::get('/contacts/{id}', [ContactController::class, 'detailContact'])->name('contacts.detailContact'); // Detail kontak
Route::get('/contacts/{id}/edit', [ContactController::class, 'editForm'])->name('contacts.edit'); // Form edit kontak
Route::put('/contacts/{id}', [ContactController::class, 'update'])->name('contacts.update'); // Update kontak
Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy'); // Hapus kontak

// Update status lead
Route::put('/contacts/{id}/update-lead-status', [ContactController::class, 'updateLeadStatus'])->name('contacts.updateLeadStatus');

// Log Aktivitas
Route::get('/contacts/logs', [ContactController::class, 'logs'])->name('contacts.logs');

// Rute untuk pendaftaran pengguna
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Rute untuk login pengguna
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

// Rute untuk logout pengguna
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');
