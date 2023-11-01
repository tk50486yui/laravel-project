<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Tags;

class TagsRepo
{
    public function getAll()
    {     
        return Tags::all();
    }   

    public function find($id)
    {     
        return Tags::where('id', $id)->first();
    }

    public function findAll()
    {     
        return Tags::orderBy('ts_order', 'ASC')->get();
    } 

    public function findByName($ts_name)
    {
        return Tags::where('ts_name', $ts_name)->first();
    }

    public function findRecent()
    {     
        return Tags::orderBy('created_at', 'DESC')
                    ->orderBy('updated_at', 'DESC')
                    ->get();
    }

    public function add($data)
    {
        $new = Tags::create([
            'ts_name' => $data['ts_name'],
            'ts_storage' => $data['ts_storage'],
            'ts_parent_id' => $data['ts_parent_id'],
            'ts_level' => $data['ts_level'],
            'ts_order' => $data['ts_order'],
            'ts_description' => $data['ts_description']
        ]);
        
        return $new->id;
    }

    public function edit($data, $id)
    {
        $tags = Tags::find($id);
        $tags->update([
            'ts_name' => $data['ts_name'],
            'ts_storage' => $data['ts_storage'],
            'ts_parent_id' => $data['ts_parent_id'],
            'ts_level' => $data['ts_level'],
            'ts_order' => $data['ts_order'],
            'ts_description' => $data['ts_description']
        ]);
    }

    public function findCheckParent($id, $ts_parent_id)
    {  
        $param = array('ts_parent_id' => $ts_parent_id, 'id' => $id);
        $query = "SELECT * FROM tags WHERE ts_parent_id = :id AND id = :ts_parent_id";
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

    // Tree
    function buildTagsTree($tags, $parent_id = null, $parents = []) {

        $tree = array();
    
        foreach ($tags as $tag) {
            if ($tag['ts_parent_id'] == $parent_id) {
                $node = array(
                    'id' => $tag['id'],
                    'ts_name' => $tag['ts_name'],
                    'ts_parent_id' => $tag['ts_parent_id'],
                    'ts_level' => $tag['ts_level'],
                    'ts_order' => $tag['ts_order'],
                    'parents' => $parents,
                    'children' => $this->buildTagsTree($tags, $tag['id'], array_merge($parents, [$tag['id']]))
                );              
    
                $tree[] = $node;
            }
        }
    
        return $tree;
    }
    
}