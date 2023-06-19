<?php

use App\Http\Controllers\AllergenController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\DCategoryController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\ICategoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\IngredientController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\TurnController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserBookingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDishController;

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


Route::group(['prefix' => 'profile', 'middleware' => 'auth'], function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profile.index');

    Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/editPassword', [ProfileController::class, 'editPassword'])->name('profile.editPassword');

    Route::put('/updatePassword', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});


Route::resource('/userbookings', UserBookingController::class)->parameters([
    'userbookings' => 'booking',
])->except(['show', 'edit', 'update']);


Route::resource('/userdishes', UserDishController::class)->parameters([
    'userdishes' => 'dish',
])->only(['index', 'show']);


Route::group(['prefix' => 'admin', 'middleware' => 'role:SuperAdmin'], function () {
    Route::get('/', function () {
        return view('admin.home');
    })->name('admin');

    Route::resource('/users', UserController::class)->except(['create', 'store', 'show']);
    Route::get('/users/search', [ProfileController::class, 'editPassword'])->name('profile.editPassword');


    Route::resource('/icategories', ICategoryController::class)->except(['show']);

    Route::resource('/ingredients', IngredientController::class)->except(['show']);

    Route::resource('/dishes', DishController::class)->except(['show']);

    Route::resource('/types', TypeController::class)->except(['show']);

    Route::resource('/dcategories', DCategoryController::class)->except(['show']);

    Route::resource('/allergens', AllergenController::class)->except(['show']);

    Route::resource('/menus', MenuController::class)->except(['show']);


    Route::resource('/turns', TurnController::class)->except(['show']);
    Route::get('/turns/copyStructure', [TurnController::class, 'copyStructure'])->name('turns.copyStructure');
    Route::post('/turns/storeCopyStructure', [TurnController::class, 'storeCopyStructure'])->name('turns.storeCopyStructure');
    Route::post('/turns/destroyStructure', [TurnController::class, 'destroyStructure'])->name('turns.destroyStructure');

    Route::resource('/tables', TableController::class)->except(['show']);

    Route::resource('/bookings', BookingController::class)->only(['index', 'destroy']);


    Route::resource('/configurations', ConfigurationController::class)->only(['index', 'edit', 'update']);
});