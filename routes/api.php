<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//})
Route::post('register',  [ApiController::class,'register']);
Route::post('login',  [ApiController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('profile', [ApiController::class,'profile']);
    Route::get('logout', [ApiController::class,'logout']);
});
