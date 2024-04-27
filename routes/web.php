<?php

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
    return view('welcome');
});

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');


Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

    Route::get('/v1/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('v1.dashboard');
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('forms', 'forms')->name('forms');
    Route::view('cards', 'cards')->name('cards');
    Route::view('charts', 'charts')->name('charts');
    Route::view('buttons', 'buttons')->name('buttons');
    Route::view('modals', 'modals')->name('modals');
    Route::view('tables', 'tables')->name('tables');
    Route::view('calendar', 'calendar')->name('calendar');

    Route::get('stores', [\App\Http\Controllers\StoreController::class, 'index'])->name('stores.index');
    Route::post('stores', [\App\Http\Controllers\StoreController::class, 'store'])->name('stores.store');
    Route::get('stores/create', [\App\Http\Controllers\StoreController::class, 'create'])->name('stores.create');
    Route::get('stores/{store}', [\App\Http\Controllers\StoreController::class, 'show'])->name('stores.show');
    Route::patch('stores/{store}',[\App\Http\Controllers\StoreController::class,'update'])->name('stores.update');
});
