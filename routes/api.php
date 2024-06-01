<?php

use App\Http\Controllers\API\CitizenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/check', [CitizenController::class, 'check']);
Route::post('/redeem', [CitizenController::class, 'register']);


Route::get('logs', function (Request $request) {

    $id = $request->input('id');
    if (is_numeric($id)) {
        return \App\Models\RequestLog::query()->where('id', $id)->paginate(5);
    }

    return \App\Models\RequestLog::query()->paginate(5);
});
