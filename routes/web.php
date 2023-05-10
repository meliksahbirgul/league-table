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

Route::get('/', 'App\Http\Controllers\HomeController@index');
Route::get('/reset-all', 'App\Http\Controllers\HomeController@resetLeague');
Route::get('/standings', 'App\Http\Controllers\HomeController@getStandings');
Route::get('/fixtures', 'App\Http\Controllers\HomeController@getFixtures');

Route::get('/prediction', 'App\Http\Controllers\PredictionController@getPrediction');

Route::get('/play-all-weeks', 'App\Http\Controllers\SimulationController@playAll');
Route::get('/play-week/{weekId}', 'App\Http\Controllers\SimulationController@playWeek');
