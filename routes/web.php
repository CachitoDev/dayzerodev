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

    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    /**
     *
     */
    Route::get('citizens', [\App\Http\Controllers\CitizenController::class, 'index'])->name('citizens.index');
    Route::get('citizens', [\App\Http\Controllers\CitizenController::class, 'index'])->name('citizens.index');
    Route::put('citizens/{citizen}', [\App\Http\Controllers\CitizenController::class, 'verifiedCitizen'])->name('citizens.verifiedCitizen');

    /**
     *
     */
    Route::get('statistics', [\App\Http\Controllers\StatisticsController::class, 'index'])->name('statistics.index');

     /**
      *
      */
    Route::get('stores', [\App\Http\Controllers\StoreController::class, 'index'])->name('stores.index');
    Route::post('stores', [\App\Http\Controllers\StoreController::class, 'store'])->name('stores.store');
    Route::get('stores/create', [\App\Http\Controllers\StoreController::class, 'create'])->name('stores.create');
    Route::get('stores/{store}', [\App\Http\Controllers\StoreController::class, 'show'])->name('stores.show');
    Route::patch('stores/{store}',[\App\Http\Controllers\StoreController::class,'update'])->name('stores.update');
});

Route::get('redeem',[\App\Http\Controllers\RedeemController::class,'create'])->name('redeem.create');
