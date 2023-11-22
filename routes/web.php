<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TopCategoryController;
use App\Http\Controllers\ApiController;

//Route::get('/appTopCategory', [TopCategoryController::class, 'show']);
Route::middleware(['throttle:5,1', 'log.request'])->get('/appTopCategory', [TopCategoryController::class, 'show']);


Route::post('/submit-api-form', [ApiController::class, 'submitForm']);


Route::get('/api_form', function () {
    return view('api_form');
});
