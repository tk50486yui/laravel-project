<?php

namespace App\Http\Controllers;

use App\Services\WordsGroupsDetailsService;

class WordsGroupsDetailsController extends Controller
{
    public function findAll()
    {
        $WordsGroupsDetailsService = new WordsGroupsDetailsService();
        $result = $WordsGroupsDetailsService->getAll();
       
        return response()->json($result);
    }
}
