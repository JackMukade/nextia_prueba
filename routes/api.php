<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BienesController;

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

Route::controller(AuthenticationController::class)->group(function () {
   
    Route::post('users/create'  , 'create');

    Route::post('users/login'   , 'login');
    
    Route::get('users/logout'   , 'logout')->middleware('auth:api');

    Route::get('users/refresh'  , 'refresh')->middleware('auth:api');

});

Route::middleware(['auth:api'])->group(function () {

    Route::post('bienes/create'      , [BienesController::class, 'create']);

    Route::get('bienes/files'        , [BienesController::class, 'filescsv']);

    Route::get('bienes/read/{id}'    , [BienesController::class, 'read']);

    Route::get('bienes/filter/{id}'  , [BienesController::class, 'filter']);

    Route::put('bienes/update'       , [BienesController::class, 'update']);

    Route::delete('bienes/delete'    , [BienesController::class, 'delete']);

});