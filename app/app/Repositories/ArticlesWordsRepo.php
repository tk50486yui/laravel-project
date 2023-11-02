<?php

namespace App\Repositories;

use App\Models\ArticlesWords;

class ArticlesWordsRepo
{
    public function getAll()
    {
        return ArticlesWords::all();
    }
}