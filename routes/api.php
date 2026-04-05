<?php

use App\Http\Controllers\ManagerController;
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

