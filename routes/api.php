<?php

use Illuminate\Http\Request;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\SessionController;
use App\Http\Controllers\API\PurposeController;
use App\Http\Controllers\API\OrganizationController;
use App\Http\Controllers\API\DateNoteController;
use App\Http\Controllers\API\BookingController;
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
route::middleware(['auth:sanctum', 'verified'])->group(function(){
    Route::get   ('user/show', [UserController::class, 'show']);
    Route::post  ('user/update', [UserController::class, 'update']);
    Route::get   ('logout', [UserController::class, 'logout']);
    
    Route::get   ('document', [DateNoteController::class, 'document']);
    Route::post  ('document', [DateNoteController::class, 'create']);
    Route::post  ('document/{id}', [DateNoteController::class, 'update']);
    Route::delete('document/{id}', [DateNoteController::class, 'delete']);
});
