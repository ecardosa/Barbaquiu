<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\BarbecuesController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoogleController;


Route::get('/', [IndexController::class, 'show'])->name('index');

Route::middleware('auth')->group(function () {
    Route::resource('profile', ProfileController::class)->only(['edit', 'update', 'destroy']);
});

Route::get('/test', [TestController::class, 'index'])->name('test');
Route::get('/test/profile', [TestController::class, 'indexProfile'])->name('test.profile');

Route::resource('profile', ProfileController::class);




Route::get('friends', [FriendsController::class, 'index'])->name('friends.index');

Route::get('/auth/google', [GoogleController::class, 'index']);
Route::get('/auth/google/callback', [GoogleController::class, 'store']);

Route::middleware('auth')->group(function () {
    Route::resource('profile', ProfileController::class);
 
    
});

Route::delete('friends/{id}', [FriendsController::class, 'destroy'])->name('friends.destroy');




Route::get('/api/user', [UserController::class, 'apiShowLogged']);

Route::resource('barbecues', BarbecuesController::class);

require __DIR__ . '/auth.php';


