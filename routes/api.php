<?php

use App\Http\Controllers\Api\ApartmentController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// retrieve all messages related to a user // http://127.0.0.1:8000/api/users/{user}/messages
Route::get('users/{user}/messages', [UserController::class, 'getUserMessages']);

// retrieve all apartments // http://127.0.0.1:8000/api/apartments/all
Route::get('apartments/all', [ApartmentController::class, 'index']);

//  retrieve apartments ordered by sponsor // http://127.0.0.1:8000/api/apartments/orderedBySponsored
Route::get('apartments/all/orderedBySponsored', [ApartmentController::class, 'getApartmentsOrderedBySponsored']);

// retrieve all services related to apartment // http://127.0.0.1:8000/api/apartments/{apartment}/services
Route::get('apartments/{apartment}/services', [ApartmentController::class, 'getApartmentServices']);

// retrieve all images related to apartment // http://127.0.0.1:8000/api/apartments/{apartment}/images
Route::get('apartments/{apartment}/images', [ApartmentController::class, 'getApartmentImages']);


