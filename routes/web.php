<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LokacijeController;
use App\Http\Controllers\SmjestajiController;
use App\Http\Controllers\BeachController;
use App\Http\Controllers\HbeachController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ContactController;



Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/lokacije', [LokacijeController::class, 'index'])->name('lokacije');
Route::get('/smjestaji', [SmjestajiController::class, 'index'])->name('smjestaji');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::get('/register', [AuthController::class, 'register'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'store']);

Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');




// Route::get('/beaches', [BeachController::class, 'index'])->name('beaches.index');
// Route::get('/beaches/create', [BeachController::class, 'create'])->name('beaches.create');
// Route::post('/beaches', [BeachController::class, 'store'])->name('beaches.store');
// Route::get('/beaches/{id}/edit', [BeachController::class, 'edit'])->name('beaches.edit');
// Route::put('/beaches/{id}', [BeachController::class, 'update'])->name('beaches.update');
// Route::delete('/beaches/{id}', [BeachController::class, 'destroy'])->name('beaches.destroy');




Route::get('/beaches', [BeachController::class, 'index'])->name('beaches.index');
Route::post('/beaches', [BeachController::class, 'store'])->name('beaches.store');
Route::get('/beaches/{id}/edit', [BeachController::class, 'edit'])->name('beaches.edit');
Route::put('/beaches/{id}', [BeachController::class, 'update'])->name('beaches.update');
Route::delete('/beaches/{id}', [BeachController::class, 'destroy'])->name('beaches.destroy');
Route::delete('/beaches/image/{id}', [BeachController::class, 'deleteImage'])->name('beaches.image.delete');




Route::get('/apartments', [ApartmentController::class, 'index'])->name('apartments.index'); // List all apartments
Route::get('/apartments/create', [ApartmentController::class, 'create'])->name('apartments.create'); // Show form to create a new apartment
Route::post('/apartments', [ApartmentController::class, 'store'])->name('apartments.store'); // Store a new apartment
Route::get('/apartments/{id}', [ApartmentController::class, 'show'])->name('apartments.show'); // Show a single apartment
Route::get('/apartments/{id}/edit', [ApartmentController::class, 'edit'])->name('apartments.edit'); // Show form to edit an apartment
Route::put('/apartments/{id}', [ApartmentController::class, 'update'])->name('apartments.update'); // Update an apartment
Route::delete('/apartments/{id}', [ApartmentController::class, 'destroy'])->name('apartments.destroy'); // Delete an apartment
Route::delete('/apartments/image/{id}', [ApartmentController::class, 'deleteImage'])->name('apartments.image.delete');
Route::post('/apartment-infos', [ApartmentController::class, 'storeInfo'])->name('apartmentInfos.store');
Route::put('/apartment-infos/{id}', [ApartmentController::class, 'updateInfo'])->name('apartmentInfos.update');
Route::delete('/apartment-infos/{id}', [ApartmentController::class, 'deleteInfo'])->name('apartmentInfos.destroy');
