<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmaController;
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

Route::controller(EmaController::class)->group(function () {
    Route::get('/{exam}', 'getSubjects')->whereIn('exam', ['jc', 'lc', 'lca']);
    Route::get('/{exam}/{subject}', 'getYears')->whereIn('exam', ['jc', 'lc', 'lca']);
    Route::get('/{exam}/{subject}/{year}', 'getMaterials')->whereIn('exam', ['jc', 'lc', 'lca'])->whereNumber("year")->middleware("increment.uses");
});