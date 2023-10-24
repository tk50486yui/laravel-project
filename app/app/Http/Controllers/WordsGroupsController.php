<?php

namespace App\Http\Controllers;

use App\Services\WordsGroupsService;

class WordsGroupsController extends Controller
{
    public function findAll()
    {
        $WordsGroupsService = new WordsGroupsService();
        $result = $WordsGroupsService->getAll();
       
        return response()->json($result);
    }
}
