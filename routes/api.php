<?php

use Illuminate\Http\Request;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\DocumentController;
use App\Http\Controllers\API\LogicalController;
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

Route::post  ('login', [UserController::class, 'login']);
Route::post  ('register', [UserController::class, 'register']);
Route::get   ('logical', [LogicalController::class, 'index']);
route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get   ('user/show', [UserController::class, 'show']);
    Route::post  ('user/update', [UserController::class, 'update']);
    Route::get   ('logout', [UserController::class, 'logout']);
    
    Route::get   ('document', [DocumentController::class, 'index']);
    Route::post  ('document', [DocumentController::class, 'create']);
    Route::post  ('document/{id}', [DocumentController::class, 'update']);
    Route::delete('document/{id}', [DocumentController::class, 'delete']);
});
