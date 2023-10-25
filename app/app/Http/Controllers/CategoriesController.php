<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoriesService;

class CategoriesController extends Controller
{
    public function find(Request $request, $id)
    {
        $CategoriesService= new CategoriesService();
        $result = $CategoriesService->find($id);
       
        return response()->json($result);
    }

    public function findAll()
    {
        $CategoriesService= new CategoriesService();
        $result = $CategoriesService->findAll();
       
        return response()->json($result);
    }

    public function findRecent()
    {     
        $CategoriesService = new CategoriesService();
        $result = $CategoriesService->findRecent();      
    
        return response()->json($result);
    }
}
