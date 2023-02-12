<?php

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

Route::post("/create-vehicle",'VehicleController@createVehicle');
Route::post("/create-category",'VehicleController@createCategory');
Route::post("/create-brand",'VehicleController@createBrand');
Route::post("/create-model",'VehicleController@createModel');
Route::post("/create-variant",'VehicleController@createVariant');

Route::post("/list-vehicles","VehicleController@getVehicles");
Route::get("/list-categories","VehicleController@getCategories");
