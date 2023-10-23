<?php

namespace App\Http\Controllers;

use App\Services\WordsService;

class WordsController extends Controller
{
    public function findAll()
    {
        $WordsService = new WordsService();
        $result = $WordsService->getAll();
       
        return response()->json($result);
    }
}
