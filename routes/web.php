<?php

use App\Http\Controllers\APIController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/home2', [HomeController::class,'home2'])->name('home2');
Route::get('/search', [HomeController::class,'search'])->name('search');
Route::prefix('api')->group(function () {
    Route::get('main', [APIController::class,'mainsearch'])->name('mainsearch');
    Route::get('country/{id}', [APIController::class,'country'])->name('country');
    Route::get('institute/{id}', [APIController::class,'institute'])->name('institute');
    Route::get('level/{id}', [APIController::class,'level'])->name('level');
    Route::get('all', [APIController::class,'all'])->name('all');
    // Route::get('course/{id}',[DropdownController::class,'course'])->name('course');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
