<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WordsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\TagsColorController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\WordsGroupsController;

Route::group(['prefix' => 'words'], function () {
    Route::get('/', [WordsController::class, 'findAll']);
    Route::get('/search', [WordsController::class,'search'])->where('text', '.*');
    Route::get('/{id}', [WordsController::class,'find']);

    Route::post('/', [WordsController::class, 'add']);
    Route::post('/upload', [WordsController::class, 'upload']);
    Route::post('/upload/uppy', [WordsController::class, 'uppyUpload']);

    Route::put('/{id}', [WordsController::class, 'edit']);
   
    Route::patch('/common/{id}', [WordsController::class, 'editCommon']);
    Route::patch('/important/{id}', [WordsController::class, 'editImportant']);

    Route::delete('/{id}', [WordsController::class, 'deleteByID']);   
});

Route::group(['prefix' => 'categories'], function () {
    Route::get('/recent',[CategoriesController::class, 'findRecent']);
    Route::get('/', [CategoriesController::class, 'findAll']);
    Route::get('/{id}', [CategoriesController::class, 'find']);

    Route::post('/', [CategoriesController::class, 'add']);

    Route::put('/{id}', [CategoriesController::class, 'edit']);
    
    Route::patch('/sort', [CategoriesController::class, 'editOrder']);

    Route::delete('/{id}', [CategoriesController::class, 'deleteByID']);
});

Route::group(['prefix' => 'tags'], function () {
    Route::get('/recent', [TagsController::class, 'findRecent']);
    Route::get('/', [TagsController::class, 'findAll']);
    Route::get('/{id}', [TagsController::class, 'find']);    

    Route::post('/', [TagsController::class, 'add']);

    Route::put('/{id}', [TagsController::class, 'edit']);

    Route::patch('/sort', [TagsController::class, 'editOrder']);

    Route::delete('/{id}', [TagsController::class, 'deleteByID']);
});

Route::group(['prefix' => 'tagscolor'], function () {
    Route::get('/', [TagsColorController::class, 'findAll']); 
    Route::get('/{id}', [TagsColorController::class, 'find']);

    Route::post('/', [TagsColorController::class, 'add']);

    Route::put('/{id}', [TagsColorController::class, 'edit']);

    Route::delete('/{id}', [TagsColorController::class, 'deleteByID']);
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