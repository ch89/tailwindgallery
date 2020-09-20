<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("photos/{photo}/like", [PhotoController::class, "like"])->middleware("auth:api");
Route::post("photos/{photo}/rate", [PhotoController::class, "rate"])->middleware("auth:api");
Route::resource("photos", PhotoController::class)->middleware("auth:api");

Route::resource("channels", ChannelController::class)->middleware("auth:api");

Route::post("register", [AuthController::class, "register"]);
Route::post("login", [AuthController::class, "login"]);
Route::post("logout", [AuthController::class, "logout"]);

Route::post("profiles", [ProfileController::class, "store"])->middleware("auth:api");