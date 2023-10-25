<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WordsService;

class WordsController extends Controller
{
    public function find(Request $request, $id)
    {
        $WordsService = new WordsService();
        $result = $WordsService->find($id);
       
        return response()->json($result);
    }

    public function findAll()
    {
        $WordsService = new WordsService();
        $result = $WordsService->findAll();
       
        return response()->json($result);
    }
    
}
