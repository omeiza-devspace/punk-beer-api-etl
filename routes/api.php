<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeerController;

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

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');
Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:sanctum')->name('refresh');
Route::post('/user', [AuthController::class, 'user'])->middleware('auth:sanctum')->name('user');
Route::post('/register', [AuthController::class, 'register'])->name('register');


Route::middleware('auth:sanctum')prefix('beers')->group(function () {
    Route::get('/', [BeerController::class, 'index'])->name('beers.index');
    Route::get('{id}', [BeerController::class, 'show'])->name('beers.show');
    Route::get('properties', [BeerController::class, 'getAllProperties'])->name('beers.properties');
    Route::get('search-id/{id}', [BeerController::class, 'getBeerById'])->name('beers.byId');
    Route::get('search-name/{name}', [BeerController::class, 'getBeerByName'])->name('beers.byName');
    Route::get('get-external-data', [BeerController::class, 'getPunkbeerAPIData'])->name('beers.externalData');
    Route::get('search-limit-and-offset', [BeerController::class, 'getWithLimitAndOffset'])->name('beers.withLimitAndOffset');
    Route::get('search-paginated-data', [BeerController::class, 'getPaginatedData'])->name('beers.paginatedData');
});