<?php

namespace App\Http\Controllers;

use App\Models\Words;

class WordsController extends Controller
{
    public function findAll()
    {
        $wordsModel = new Words();
        $words = $wordsModel->getAll();
       
        return response()->json($words);
    }
}
