<?php

use App\Http\Controllers\AllergenController;
use App\Http\Controllers\Auth\VerificationController;
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
    $user = Auth::user();
    if ($user && $user->hasRole('SuperAdmin')) return redirect()->route('admin.index');
    return view('index');
})->name('index');

Auth::routes(['verify' => true]);

Route::resource('/userdishes', UserDishController::class)->parameters([
    'userdishes' => 'dish',
])->only(['index', 'show']);


/////////////////
// Auth routes //
/////////////////
Route::group(['prefix' => 'profile', 'middleware' => 'auth'], function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
});


/////////////////
// User routes //
/////////////////
Route::group(['prefix' => 'userbookings', 'middleware' =>  ['role:User', 'verified']], function () {
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
        return view('admin');
    })->name('admin.index');


    Route::resource('/users', UserController::class)->only(['index', 'create', 'store']);
    Route::post('/users/toggleDisable', [UserController::class, 'toggleDisable'])->name('users.toggleDisable');
    Route::get('/users/registerRequests', [UserController::class, 'registerRequests'])->name('users.registerRequests');
    Route::put('/users/accept/{user}', [UserController::class, 'accept'])->name('users.accept');
    Route::get('/users/profile/{user}', [UserController::class, 'profile'])->name('users.profile');


    Route::resource('/icategories', ICategoryController::class)->except(['show', 'destroy']);

    Route::resource('/ingredients', IngredientController::class)->except(['show', 'destroy']);
    Route::post('/ingredients/destroy', [IngredientController::class, 'destroy'])->name('ingredients.destroy');

    Route::resource('/dishes', DishController::class)->except(['show', 'destroy']);
    Route::post('/dishes/destroy', [DishController::class, 'destroy'])->name('dishes.destroy');

    Route::resource('/types', TypeController::class)->except(['show', 'destroy']);

    Route::resource('/dcategories', DCategoryController::class)->except(['show', 'destroy']);
    Route::post('/dcategories/destroy', [DCategoryController::class, 'destroy'])->name('dcategories.destroy');

    Route::resource('/allergens', AllergenController::class)->except(['show', 'destroy']);
    Route::post('/allergens/destroy', [AllergenController::class, 'destroy'])->name('allergens.destroy');

    Route::resource('/menus', MenuController::class)->except(['show', 'destroy']);
    Route::post('/menus/destroy', [MenuController::class, 'destroy'])->name('menus.destroy');


    Route::resource('/turns', TurnController::class)->except(['show', 'destroy']);
    Route::post('/turns/destroy', [TurnController::class, 'destroy'])->name('turns.destroy');

    Route::resource('/tables', TableController::class)->except(['show', 'destroy']);
    Route::post('/tables/destroy', [TableController::class, 'destroy'])->name('tables.destroy');

    Route::resource('/bookings', BookingController::class)->only(['index']);
    Route::post('/bookings/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');


    Route::resource('/configurations', ConfigurationController::class)->only(['index', 'edit', 'update']);
});
