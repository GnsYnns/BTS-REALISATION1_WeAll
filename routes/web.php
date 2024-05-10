<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;

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
Route::post("message", [PostController::class, 'store'])->name('message.store');
Route::get('message', [PostController::class, 'index'])->name('message.index');

Route::get('/dashboard', [PostController::class, 'showDashboard'])->name('dashboard');

Route::post('/like/{post_message}/like', [LikeController::class, 'like']);
Route::get('/like/hasUserLikedPost/{id}', [LikeController::class, 'hasUserLikedPost']);


Route::get('/mention', function () {
    return view('mention');
})->name('mention');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [PostController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
