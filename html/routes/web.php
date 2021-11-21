<?php

use App\Models\Search;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
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

Route::get('/search', [Controllers\SearchController::class, 'show']);

Route::get('/results', [Controllers\ResultsController::class, 'show']);

Route::get('/download', [Controllers\DownloadController::class, 'download']);

Route::get('/ad', [Controllers\AdController::class, 'show']); 

Route::get('/discuss', [Controllers\DiscussController::class, 'show']);

Route::get("/contact", function(){
    return view("contact");
});

Route::get("/poster", function(){
    return view("poster");
});

Route::get("/tc", function(){
    return view("tc");
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/discuss', [Controllers\CommentsController::class, 'store']);