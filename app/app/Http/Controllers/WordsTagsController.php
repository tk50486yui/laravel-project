<?php

namespace App\Http\Controllers;

use App\Services\WordsTagsService;

class WordsTagsController extends Controller
{
    public function findAll()
    {
        $WordsTagsService = new WordsTagsService();
        $result = $WordsTagsService->getAll();
       
        return response()->json($result);
    }
}
