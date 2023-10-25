<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TagsService;

class TagsController extends Controller
{
    public function find(Request $request, $id)
    {
        $TagsService = new TagsService();
        $result = $TagsService->find($id);
       
        return response()->json($result);
    }

    public function findAll()
    {
        $TagsService = new TagsService();
        $result = $TagsService->findAll();
       
        return response()->json($result);
    }

    public function findRecent()
    {     
        $TagsService = new TagsService();
        $result = $TagsService->findRecent();      
    
        return response()->json($result);
    }
}
