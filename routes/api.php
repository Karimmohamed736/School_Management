<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeachingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::middleware('IsManager','auth:sanctum')->group(function () {
Route::controller(ManagerController::class)->group(function(){
Route::post('manager/register','register');
Route::post('manager/login','login');
Route::delete('manager/logout','logout')->middleware('auth:sanctum');
});
// });

Route::controller(ClassroomController::class)->group(function(){
    Route::get('classrooms','index');
    Route::post('classrooms','store');
    Route::get('classrooms/{id}','show');
    Route::put('classrooms/{id}','update');
    Route::delete('classrooms/{id}','delete');
});

Route::controller(TeacherController::class)->group(function(){
    Route::get('teachers','index');
    Route::post('teachers','store');
    Route::get('teachers/{id}','show');
    Route::put('teachers/{id}','update');
    Route::delete('teachers/{id}','delete');
});

Route::controller(SubjectController::class)->group(function(){
    Route::get('subjects','index');
    Route::post('subjects','store');
    Route::get('subjects/{id}','show');
    Route::put('subjects/{id}','update');
    Route::delete('subjects/{id}','delete');
});

Route::controller(TeachingController::class)->group(function(){
    Route::get('teachings','index');
    Route::post('teachings','store');
    Route::get('teachings/{id}','show');
    Route::put('teachings/{id}','update');
    Route::delete('teachings/{id}','delete');
});
