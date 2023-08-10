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


///////////////////
// Public routes //
///////////////////
Route::get('/', function () {
    return view('index');
})->name('index');

Auth::routes();

Route::resource('/userdishes', UserDishController::class)->parameters([
    'userdishes' => 'dish',
])->only(['index', 'show']);


/////////////////
// Auth routes //
/////////////////
Route::group(['prefix' => 'profile', 'middleware' => 'auth'], function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profile.index');

    Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/editPassword', [ProfileController::class, 'editPassword'])->name('profile.editPassword');

    Route::put('/updatePassword', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});


/////////////////
// User routes //
/////////////////
Route::group(['prefix' => 'userbookings', 'middleware' => 'role:User'], function () {
    Route::resource('/', UserBookingController::class, ['names' => [
        'index' => 'userbookings.index',
        'store' => 'userbookings.store',
    ]])->parameters([
        'userbookings' => 'booking',
    ])->only(['index', 'store']);
    Route::get('/create/{turn}', [UserBookingController::class, 'create'])->name('userbookings.create');
    Route::get('/available', [UserBookingController::class, 'available'])->name('userbookings.available');
    Route::put('/cancel/{booking}', [UserBookingController::class, 'cancel'])->name('userbookings.cancel');
    Route::get('/history', [UserBookingController::class, 'history'])->name('userbookings.history');
});


//////////////////
// Admin routes //
//////////////////
Route::group(['prefix' => 'admin', 'middleware' => 'role:SuperAdmin'], function () {
    Route::get('/', function () {
        return view('admin.home');
    })->name('admin');


    Route::resource('/users', UserController::class)->only(['index', 'create', 'store']);
    Route::put('/users/toggleDisable/{user}', [UserController::class, 'toggleDisable'])->name('users.toggleDisable');
    Route::get('/users/registerRequests', [UserController::class, 'registerRequests'])->name('users.registerRequests');
    Route::put('/users/accept/{user}', [UserController::class, 'accept'])->name('users.accept');


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

    Route::resource('/bookings', BookingController::class)->only(['index']);
    Route::put('/bookings/cancel/{booking}', [BookingController::class, 'cancel'])->name('bookings.cancel');


    Route::resource('/configurations', ConfigurationController::class)->only(['index', 'edit', 'update']);
});
