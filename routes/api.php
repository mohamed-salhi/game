<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\chooesController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\truefalseController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(callback: function (){
    Route::apiResource('level',LevelController::class);
    Route::apiResource('truefalse',truefalseController::class);
    Route::get('gettruefalsedit/{id}',[truefalseController::class,'gettruefalsedit']);
    Route::get('gettlevel',[truefalseController::class,'gettlevel']);
    Route::apiResource('chooes',chooesController::class);
    Route::get('getchooesedit/{id}',[chooesController::class,'getchooesedit']);

    Route::get('gettleveluser',[LevelController::class,'gettleveluser']);
    Route::post('postlevelsoultion',[LevelController::class,'postlevelsoultion']);

    Route::get('getqustion/{id}',[LevelController::class,'getqustion']);
    Route::post('postqustionsoultion',[LevelController::class,'postqustionsoultion']);









});

Route::middleware(['guest:sanctum'])->group(function () {
    Route::post('auth/login',[authController::class,'login']);
    Route::post('auth/register',[authController::class,'register']);
});
