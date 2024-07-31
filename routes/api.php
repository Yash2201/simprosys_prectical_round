<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DecryptResponseController;
use App\Http\Middleware\CheckToken;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware(CheckToken::class)->group(function () {

    Route::get('/product/list',[ProductController::class,'product_list']);
    Route::post('/product/store',[ProductController::class,'store']);
    Route::post('/product/edit',[ProductController::class,'edit']);
    Route::put('/product/update',[ProductController::class,'update']);
    Route::delete('/product/delete/{id}',[ProductController::class,'destroy']);
    
    Route::post('/category/store',[CategoryController::class,'store']);
    Route::get('/category/list',[CategoryController::class,'category_list']);
    
    
    Route::post('/decrypt_response',[DecryptResponseController::class,'decrypt_response']);
});
