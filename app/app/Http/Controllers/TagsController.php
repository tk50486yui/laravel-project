<?php

namespace App\Http\Controllers;

use App\Services\TagsService;

class TagsController extends Controller
{
    public function findAll()
    {
        $TagsService = new TagsService();
        $result = $TagsService->findAll();
       
        return response()->json($result);
    }
}
