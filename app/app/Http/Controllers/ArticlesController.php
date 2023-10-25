<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ArticlesService;

class ArticlesController extends Controller
{
    public function find(Request $request, $id)
    {
        $ArticlesService= new ArticlesService();
        $result = $ArticlesService->find($id);
       
        return response()->json($result);
    }

    public function findAll()
    {
        $ArticlesService = new ArticlesService();
        $result = $ArticlesService->findAll();
       
        return response()->json($result);
    }
}
