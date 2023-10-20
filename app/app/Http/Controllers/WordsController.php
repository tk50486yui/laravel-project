<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Words;

class WordsController extends Controller
{
    public function findAll()
    {
        $wordsModel = new Words();
        $words = $wordsModel->getAll();
       
        return response()->json($words);
    }
}
