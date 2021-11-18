<?php

use App\Models\Search;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;

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

Route::get('/search', 'App\Http\Controllers\SearchController@show');

Route::get('/results', 'App\Http\Controllers\ResultsController@show');

Route::get('/download', 'App\Http\Controllers\DownloadController@download');

Route::get('/ad', 'App\Http\Controllers\AdController@show'); 

Route::get('/discuss', 'App\Http\Controllers\DiscussController@show');