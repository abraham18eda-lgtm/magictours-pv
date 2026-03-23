<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Api\TourController; // controlador del api
use App\Http\Controllers\BookingController;
use App\Http\Controllers\NewsletterController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AdminTourController;  // controlador del api



// rutas publicas sin autentificar

Route::get('/tours', [TourController::class, 'index']);
Route::get('/tours/{slug}', [TourController::class, 'show']);

Route::post('/bookings', [BookingController::class, 'store']);
// Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');

// Route::get('/dashboard', [BookingController::class, 'index']);

// Rutas de traducciones
Route::get('/translations/{locale}', function ($locale) {
    $path = base_path("lang/{$locale}.json");

    if (!File::exists($path)) {
        return response()->json(['error' => 'Translation file not found'], 404);
    }

    return response()->json(json_decode(File::get($path), true));
});


// rutas con autentificacion para mi cms 
Route::prefix('admin')->group(function () {

    // Login (público)
    Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'login']);

    // Rutas protegidas
    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/user', [AuthController::class, 'user']); // opcional

        Route::get('/tours', [AdminTourController::class, 'index']);
           Route::get('/tours/{id}', [AdminTourController::class, 'show']);
        Route::put('/tours/{tour}', [AdminTourController::class, 'update']);

        Route::post('/logout', [AuthController::class, 'logout']); //
    });

});
    
// Tours API 
// Route::middleware('auth:sanctum')->group(function () {

//     Route::get('/tours', function () {
//         return \App\Models\Tour::with('translations', 'translations.amenities')->get();
//     });

//     Route::post('/tours', function (Request $request) {
//         return \App\Models\Tour::create($request->all());
//     });

//     Route::put('/tours/{id}', function ($id, Request $request) {
//         $tour = \App\Models\Tour::findOrFail($id);
//         $tour->update($request->all());
//         return $tour;
//     });

// });