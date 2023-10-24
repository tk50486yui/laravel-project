<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WordsController;
use App\Http\Controllers\WordsTagsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\ArticlesController;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::get('/user', [UserController::class, 'getUserInfo']);
Route::get('/words', [WordsController::class, 'findAll']);
Route::get('/wordstags', [WordsTagsController::class, 'findAll']);
Route::get('/categories', [CategoriesController::class, 'findAll']);
Route::get('/tags', [TagsController::class, 'findAll']);
Route::get('/articles', [ArticlesController::class, 'findAll']);
