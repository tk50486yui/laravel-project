<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Words;

class WordsRepo
{
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

        return DB::selectOne($query, array($id));
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

        return DB::select($query);
    }

    public function findByName($ws_name)
    {
        return Words::where('ws_name', $ws_name)->first();
    }    

    public function add($data)
    {
        $new = Words::create([
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
        
        return $new->id;
    }

    public function edit($data, $id)
    {
        $word = Words::find($id);
        $word->update([
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

    public function editCommon($data, $id)
    {
        $word = Words::find($id);
        $word->update([
            'ws_is_common' => $data['ws_is_common']           
        ]);
    }

    public function editImportant($data, $id)
    {
        $word = Words::find($id);
        $word->update([
            'ws_is_important' => $data['ws_is_important']
        ]);
    }

    public function updateNullByCateID($cate_id)
    {
        Words::where('cate_id', $cate_id)->update(['cate_id' => null]);
    }

}