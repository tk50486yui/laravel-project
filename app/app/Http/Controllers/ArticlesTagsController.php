<?php

namespace App\Http\Controllers;

use App\Services\ArticlesTagsService;

class ArticlesTagsController extends Controller
{
    public function findAll()
    {
        $ArticlesTagsService = new ArticlesTagsService();
        $result = $ArticlesTagsService->getAll();
       
        return response()->json($result);
    }
}
