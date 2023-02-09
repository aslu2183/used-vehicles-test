<?php

use Illuminate\Support\Facades\Route;
use Faker\Provider\Fakecar;
use Illuminate\Database\Eloquent\Factories\Factory;

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

// Route::get('/get-vehicle',function(){
//     $vehicle = $this->faker->addProvider(new Fakecar($this->faker));
//     return [
//         'data' => $vehicle
//     ];
// });
