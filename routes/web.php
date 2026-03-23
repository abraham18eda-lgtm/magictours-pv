<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsletterController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');
// Route::post('/admin/login', [AuthController::class, 'login']);

// Rutas CMS
Route::get('/admin/{any}', function () {
    return view('admin');
})->where('any', '.*');

// Luego tu catch-all general
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');