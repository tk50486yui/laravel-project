<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Words;

class WordsRepo
{
    public function getAll()
    {
     
        $result = Words::all();   
    
        return $result;
    }

    public function find($id)
    {
        $query = "SELECT 
                    ws.*, cate.cate_name as cate_name
                FROM 
                    words ws
                LEFT JOIN 
                    categories cate ON ws.cate_id =  cate.id
                WHERE 
                    ws.id = ?";

        $result =DB::select($query, array($id));    
       
        return $result;
    }

    public function findAll()
    {     
        $query = "SELECT 
                    ws.*, cate.cate_name as cate_name,
                    json_build_object('values',                   
                        (
                            SELECT 
                                json_agg(json_build_object('ts_id', ts.id, 'ts_name', ts.ts_name))
                            FROM 
                                words_tags wt
                            LEFT JOIN 
                                tags ts ON wt.ts_id = ts.id
                            WHERE 
                                wt.ws_id = ws.id
                        
                        )
                    ) AS words_tags                
                FROM 
                    words ws
                LEFT JOIN 
                    categories cate ON ws.cate_id =  cate.id                     
                ORDER BY 
                    ws.id DESC";

        $result = DB::select($query);

        return $result;   
        
    }

}