<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Articles;

class ArticlesRepo
{
    public function getAll()
    {
     
        $result = Articles::all();   
    
        return $result;
    }

    public function findAll()
    {     
        $query = "SELECT 
                    arti.*, cate.cate_name as cate_name,
                    TO_CHAR(arti.created_at, 'YYYY-MM-DD HH24:MI:SS') AS created_at, 
                    TO_CHAR(arti.updated_at, 'YYYY-MM-DD HH24:MI:SS') AS updated_at,                    
                    json_build_object('values',                   
                        (
                            SELECT 
                                json_agg(json_build_object('ts_id', ts.id, 'ts_name', ts.ts_name))
                            FROM 
                                articles_tags ats
                            LEFT JOIN 
                                tags ts ON ats.ts_id = ts.id
                            WHERE 
                                ats.arti_id = arti.id
                        
                        )
                    ) AS articles_tags
                FROM 
                    articles arti
                LEFT JOIN 
                    categories cate ON arti.cate_id = cate.id        
                ORDER BY 
                    arti.id DESC";

        $result = DB::select($query);

        return $result;   
        
    }
}