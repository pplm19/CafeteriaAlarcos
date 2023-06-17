<?php

use App\Http\Controllers\AllergenController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ICategoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\IngredientController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TurnController;
use App\Http\Controllers\TypeController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::group(['prefix' => 'admin'], function() {
Route::group(['prefix' => 'admin', 'middleware' => 'role:SuperAdmin'], function () {
    Route::get('/home', function () {
        return view('admin.home');
    })->name('admin.home');

    Route::get('/users', function () {
        return view('admin.crud.users');
    })->name('admin.users');

    Route::get('/ingredients', [IngredientController::class, 'index'])->name('admin.ingredients');

    Route::get('/icategories', [ICategoryController::class, 'index'])->name('admin.icategories');

    Route::get('/allergens', [AllergenController::class, 'index'])->name('admin.allergens');

    Route::get('/types', [TypeController::class, 'index'])->name('admin.types');

    Route::get('/menus', [MenuController::class, 'index'])->name('admin.menus');

    Route::get('/bookings', [BookingController::class, 'index'])->name('admin.bookings');

    Route::get('/turns', [TurnController::class, 'index'])->name('admin.turns');
});
