<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WordsGroupsService;

class WordsGroupsController extends Controller
{
    public function find(Request $request, $id)
    {
        $WordsGroupsService = new WordsGroupsService();
        $result = $WordsGroupsService->find($id);
       
        return response()->json($result);
    }

    public function findAll()
    {
        $WordsGroupsService = new WordsGroupsService();
        $result = $WordsGroupsService->findAll();
       
        return response()->json($result);
    }
}
