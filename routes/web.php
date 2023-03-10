<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    return view('homepage');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/user',[UserController::class, 'index'])
            ->middleware(['auth', 'verified'])
            ->name('user'); 


 Route::get('/announcement', function () {
                return view('announcement');
            })->middleware(['auth', 'verified'])->name('announcement');


Route::get('/user/add',[UserController::class, 'form'])
            ->middleware(['auth', 'verified']);
Route::post('/user/add',[UserController::class, 'store'])
            ->middleware(['auth', 'verified']);


Route::get('/user/update/{id}',[UserController::class, 'show'])
            ->middleware(['auth', 'verified']);




Route::get('/user/delete/{id}', [UserController::class, 'delete'])
            ->middleware(['auth', 'verified']);

        

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
