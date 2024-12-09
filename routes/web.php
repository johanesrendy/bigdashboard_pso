<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\ContactImportController;

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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dbconn', function () {
//     return view('dbconn');
// });


// Rute untuk menampilkan daftar kontak
// Menampilkan daftar kontak dengan pencarian, filter, dan pengurutan
Route::get('/beranda', [ContactController::class, 'index'])->name('contacts.index');

Route::get('/tracker', [ContactController::class, 'tracker'])->name('data.tracker');

Route::get('/leads', [ContactController::class, 'leads'])->name('data.leads');

Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
// Menampilkan formulir untuk menambahkan kontak baru
Route::get('/contacts/form', [ContactController::class, 'form'])->name('contacts.form');

// Menampilkan formulir untuk menambahkan kontak baru
Route::get('/contacts/import', [ContactController::class, 'import'])->name('contacts.import');

Route::post('/contacts/import', [ContactController::class, 'importPost'])->name('contacts.import.post');



// Export data leads
Route::get('/contacts/export', [ContactController::class, 'export'])->name('contacts.export');

Route::post('/contacts/export', [ContactController::class, 'exportData'])->name('contacts.export');

// Menyimpan kontak baru
Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');


// Rute untuk menampilkan detail kontak
Route::get('/contacts/{id}', [ContactController::class, 'detailContact'])->name('contacts.detailContact');

// Rute untuk menampilkan formulir untuk mengedit kontak
Route::get('/contacts/{id}/edit', [ContactController::class, 'getContact'])->name('contacts.getContact');
Route::get('/contacts/{id}/edit', [ContactController::class, 'editForm'])->name('contacts.edit');



// Rute untuk memperbarui kontak yang ada
Route::put('/contacts/{id}', [ContactController::class, 'update'])->name('contacts.update');

// Rute untuk menghapus kontak
Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');

// // Menampilkan formulir impor Excel
// Route::get('/contacts/import', [ContactController::class, 'importForm'])->name('contacts.import');




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

// Rute untuk menampilkan log aktivitas
Route::get('/contacts/logs', [ContactController::class, 'logs'])->name('contacts.logs');

// web.php
Route::put('/contacts/{id}/update-lead-status', [ContactController::class, 'updateLeadStatus'])->name('contacts.updateLeadStatus');
