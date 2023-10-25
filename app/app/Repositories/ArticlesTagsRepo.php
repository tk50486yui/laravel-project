<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\ArticlesTags;

class ArticlesTagsRepo
{
    public function getAll()
    {
     
        $result = ArticlesTags::all();   
    
        return $result;
    }

    public function findByArtiID($arti_id)
    {
        $query = "SELECT 
                    ts.id as ts_id, ts.ts_name
                FROM 
                    articles_tags ats                   
                LEFT JOIN articles arti ON ats.arti_id = arti.id 
                LEFT JOIN tags ts ON ats.ts_id =  ts.id
                WHERE 
                    ats.arti_id = ?";

        $result = DB::select($query, array($arti_id));

        return $result;
    }
}