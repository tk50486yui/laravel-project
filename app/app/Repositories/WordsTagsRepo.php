<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\WordsTags;

class WordsTagsRepo
{
    public function getAll()
    {
     
        $result = WordsTags::all();   
    
        return $result;
    }

    public function findByWordsID($ws_id)
    {
        $query = "SELECT 
                    ts.id as ts_id, ts.ts_name
                FROM 
                    words_tags wt                   
                LEFT JOIN words ws ON wt.ws_id = ws.id 
                LEFT JOIN tags ts ON wt.ts_id =  ts.id
                WHERE 
                    wt.ws_id = ?";

        $result = DB::select($query, array($ws_id));   

        return $result;
    }
}