<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Words extends Model
{
    public function getAll()
    {
     
        $words = Words::all();   
    
        return $words;
    }
}
