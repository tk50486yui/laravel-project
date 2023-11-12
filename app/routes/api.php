<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WordsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\WordsGroupsController;

Route::group(['prefix' => 'words'], function () {
    Route::get('/', [WordsController::class, 'findAll']);
    Route::get('/{id}', [WordsController::class,'find']);
    Route::post('/', [WordsController::class, 'add']);
    Route::put('/{id}', [WordsController::class, 'edit']);
   
    Route::patch('/common/{id}', [WordsController::class, 'editCommon']);
    Route::patch('/important/{id}', [WordsController::class, 'editImportant']);

    Route::delete('/{id}', [WordsController::class, 'deleteByID']);
});

Route::group(['prefix' => 'categories'], function () {
    Route::get('/', [CategoriesController::class, 'findAll']);
    Route::get('/{id}', [CategoriesController::class, 'find']);
    Route::get('/recent/all',[CategoriesController::class, 'findRecent']);

    Route::post('/', [CategoriesController::class, 'add']);
    Route::put('/{id}', [CategoriesController::class, 'edit']);
    
    Route::patch('/order/all', [CategoriesController::class, 'editOrder']);

    Route::delete('/{id}', [CategoriesController::class, 'deleteByID']);
});

Route::group(['prefix' => 'tags'], function () {
    Route::get('/', [TagsController::class, 'findAll']);
    Route::get('/{id}', [TagsController::class, 'find']);
    Route::get('/recent/all', [TagsController::class, 'findRecent']);

    Route::post('/', [TagsController::class, 'add']);
    Route::put('/{id}', [TagsController::class, 'edit']);

    Route::patch('/order/all', [TagsController::class, 'editOrder']);

    Route::delete('/{id}', [TagsController::class, 'deleteByID']);
});

Route::group(['prefix' => 'articles'], function () {
    Route::get('/', [ArticlesController::class, 'findAll']);
    Route::get('/{id}', [ArticlesController::class, 'find']);
    
    Route::post('/', [ArticlesController::class, 'add']);
    Route::put('/{id}', [ArticlesController::class, 'edit']);

    Route::delete('/{id}', [ArticlesController::class, 'deleteByID']);
});


Route::group(['prefix' => 'wordsgroups'], function () {
    Route::get('/', [WordsGroupsController::class, 'findAll']); 
    Route::get('/{id}', [WordsGroupsController::class, 'find']);

    Route::post('/', [WordsGroupsController::class, 'add']);
    Route::put('/{id}', [WordsGroupsController::class, 'edit']);

    Route::delete('/{id}', [WordsGroupsController::class, 'deleteByID']);
});