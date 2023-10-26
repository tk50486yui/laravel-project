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

    public function add($data)
    {
        return Words::create([
            'ws_name' => $data['ws_name'],
            'ws_definition' => $data['ws_definition'],
            'ws_pronunciation' => $data['ws_pronunciation'],
            'ws_slogan' => $data['ws_slogan'],
            'ws_description' => $data['ws_description'],
            'ws_is_important' => $data['ws_is_important'],
            'ws_is_common' => $data['ws_is_common'],
            'ws_forget_count' => $data['ws_forget_count'],
            'ws_order' => $data['ws_order'],
            'cate_id' => $data['cate_id']
        ]);
    }

}