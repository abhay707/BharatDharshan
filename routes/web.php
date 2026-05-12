<?php

use App\Http\Controllers\CuisineController;
use App\Http\Controllers\FestivalController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MonumentController;
use App\Http\Controllers\StateController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/states', [StateController::class, 'index'])->name('states.index');
Route::get('/states/{slug}', [StateController::class, 'show'])->name('states.show');
Route::get('/api/states/search', [StateController::class, 'search']);

Route::get('/festivals', [FestivalController::class, 'index'])->name('festivals.index');
Route::get('/festivals/{slug}', [FestivalController::class, 'show'])->name('festivals.show');
Route::get('/api/festivals/calendar', [FestivalController::class, 'calendar']);

// heritage/state/{stateSlug} MUST come before heritage/{slug} to avoid conflicts
Route::get('/heritage/state/{stateSlug}', [MonumentController::class, 'byState'])->name('monuments.by-state');
Route::get('/heritage', [MonumentController::class, 'index'])->name('monuments.index');
Route::get('/heritage/{slug}', [MonumentController::class, 'show'])->name('monuments.show');

Route::get('/cuisine', [CuisineController::class, 'index'])->name('cuisine.index');

// Quick demo auto-login (local environment only)
if (app()->environment('local')) {
    Route::get('/demo', function () {
        $admin = \App\Models\User::where('email', 'admin@bharatdarshan.com')->firstOrFail();
        auth()->login($admin);
        return redirect('/admin');
    })->name('demo');
}
