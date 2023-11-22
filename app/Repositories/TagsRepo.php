<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Tags;

class TagsRepo
{
    public function find($id)
    {     
        return Tags::where('id', $id)->first();
    }

    public function findAll()
    {     
        $query = "SELECT 
                    ts.*,
                    parent.ts_name AS ts_parent_name,
                    tc.tc_color AS tc_color,
                    tc.tc_background AS tc_background,
                    tc.tc_border AS tc_border
                FROM 
                    tags ts
                LEFT JOIN 
                    tags AS parent ON ts.ts_parent_id = parent.id
                LEFT JOIN 
                    tags_color AS tc ON ts.tc_id = tc.id
                ORDER BY 
                    ts.ts_order ASC";

        return DB::select($query);
    } 

    public function findRecent()
    {     
        $query = "SELECT 
                    ts.*,
                    parent.ts_name AS ts_parent_name,
                    tc.tc_color AS tc_color,
                    tc.tc_background AS tc_background,
                    tc.tc_border AS tc_border
                FROM 
                    tags ts
                LEFT JOIN 
                    tags AS parent ON ts.ts_parent_id = parent.id
                LEFT JOIN 
                    tags_color AS tc ON ts.tc_id = tc.id
                ORDER BY 
                    ts.created_at DESC, ts.updated_at DESC";

        return DB::select($query);
    }

    public function findByName($ts_name)
    {
        return Tags::where('ts_name', $ts_name)->first();
    }  

    public function add($data)
    {
        $new = Tags::create([
            'ts_name' => $data['ts_name'],
            'ts_parent_id' => $data['ts_parent_id'],
            'ts_level' => $data['ts_level'],
            'ts_order' => $data['ts_order'],
            'tc_id' => $data['tc_id']
        ]);
        
        return $new->id;
    }

    public function edit($data, $id)
    {
        $tags = Tags::find($id);
        $tags->update([
            'ts_name' => $data['ts_name'],
            'ts_parent_id' => $data['ts_parent_id'],
            'ts_order' => $data['ts_order'],
            'ts_level' => $data['ts_level'],
            'tc_id' => $data['tc_id']
        ]);
    }

    public function editOrder($ts_order, $id)
    {
        $tags = Tags::find($id);
        $tags->update([
            'ts_order' => $ts_order
        ]);
    }

    public function findChildren($id)
    { 
        $query = "SELECT * FROM tags
                WHERE 
                    ts_parent_id = ?
                ORDER BY 
                    ts_order ASC";

        return DB::select($query, array($id));
    }

    public function findCheckParent($id, $ts_parent_id)
    {  
        $param = array('ts_parent_id' => $ts_parent_id, 'id' => $id);
        $query = "SELECT * FROM tags 
                WHERE 
                    ts_parent_id = :id 
                AND 
                    id = :ts_parent_id";
        return DB::select($query, $param);       
    }

    public function findMaxOrderByParent($ts_parent_id)
    {
        $query = "SELECT 
                    MAX(ts_order) as max_ts_order,
                    COUNT(id) as sibling_count
                FROM 
                    tags           
                WHERE 
                    ts_parent_id = ?";

        return DB::selectOne($query, array($ts_parent_id));
    }

    public function findOrderInFirstLevel()
    {
        $query = "SELECT 
                    MAX(ts_order) as max_ts_order
                FROM 
                    tags
                WHERE 
                    ts_parent_id IS NULL";

        return DB::selectOne($query);
    }

    public function deleteByID($id)
    {
        Tags::where('id', $id)->delete();
    }

    public function updateNullByTcID($tc_id)
    {
        Tags::where('tc_id', $tc_id)->update(['tc_id' => null]);
    }
}