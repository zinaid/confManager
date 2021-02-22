<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Profile;
use App\Http\Controllers\PaperController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/submit', function () {
    return view('submit');
})->middleware(['auth'])->name('submit');

# PROFILE CONTROLLER
Route::get('profile', [Profile::class, 'index'])->middleware('auth')->name('profile');

Route::post('/finish_registration', [Profile::class, 'finish_registration']);

Route::post('/update_profile', [Profile::class, 'update_profile'])->name('update_profile');

# PAPER CONTROLLER
Route::post('/paper_submission', [PaperController::class, 'store']);

Route::get('papers', [PaperController::class, 'index'])->middleware('auth')->name('papers');

Route::get('/papers/{id}', [PaperController::class, 'show'])->middleware('auth');


require __DIR__.'/auth.php';
