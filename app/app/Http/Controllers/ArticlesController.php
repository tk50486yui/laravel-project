<?php

namespace App\Http\Controllers;

use App\Services\ArticlesService;

class ArticlesController extends Controller
{
    public function findAll()
    {
        $ArticlesService = new ArticlesService();
        $result = $ArticlesService->findAll();
       
        return response()->json($result);
    }
}
