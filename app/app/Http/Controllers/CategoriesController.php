<?php

namespace App\Http\Controllers;

use App\Models\Categories;

class CategoriesController extends Controller
{
    public function findAll()
    {
        $catrgoriesModel = new Categories();
        $catrgories = $catrgoriesModel->getAll();
       
        return response()->json($catrgories);
    }
}
