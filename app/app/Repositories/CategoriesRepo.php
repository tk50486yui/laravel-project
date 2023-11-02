<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Categories;

class CategoriesRepo
{
    public function find($id)
    {
        return Categories::where('id', $id)->first();
    }

    public function findAll()
    {
        return Categories::orderBy('cate_order', 'ASC')->get();
    }

    public function findByName($cate_name)
    {
        return Categories::where('cate_name', $cate_name)->first();
    }

    public function add($data)
    {
        $new = Categories::create([
            'cate_name' => $data['cate_name'],
            'cate_parent_id' => $data['cate_parent_id'],
            'cate_level' => $data['cate_level'],
            'cate_order' => $data['cate_order']
        ]);
        
        return $new->id;
    }

    public function edit($data, $id)
    {
        $categories = Categories::find($id);
        $categories->update([
            'cate_name' => $data['cate_name'],
            'cate_parent_id' => $data['cate_parent_id'],
            'cate_level' => $data['cate_level'],
            'cate_order' => $data['cate_order']
        ]);
    }

    public function editOrder($cate_order, $id)
    {
        $categories = Categories::find($id);
        $categories->update([
            'cate_order' => $cate_order
        ]);
    }

    public function findCheckParent($id, $cate_parent_id)
    {
        $param = array('cate_parent_id' => $cate_parent_id, 'id' => $id);
        $query = "SELECT * FROM categories 
                WHERE 
                    cate_parent_id = :id
                AND 
                    id = :cate_parent_id";

        return DB::select($query, $param);
        
    }

    public function findMaxOrderByParent($cate_parent_id)
    {
        $query = "SELECT 
                    MAX(cate_order) as max_cate_order,
                    COUNT(id) as sibling_count
                FROM 
                    categories
                WHERE 
                    cate_parent_id = ?";

        $result = DB::selectOne($query, array($cate_parent_id));
      
        return $result;
    }

    public function findOrderInFirstLevel()
    {
        $query = "SELECT 
                    MAX(cate_order) as max_cate_order
                FROM 
                    categories
                WHERE 
                    cate_parent_id IS NULL";

        $result = DB::selectOne($query);
      
        return $result;
    }

    public function findRecent()
    {     
        return Categories::orderBy('created_at', 'DESC')
                    ->orderBy('updated_at', 'DESC')
                    ->get(); 
    }

    // Tree
    function buildCategoriesTree($categories, $parent_id = null, $parents = []) {

        $tree = array();
    
        foreach ($categories as $category) {
            if ($category['cate_parent_id'] == $parent_id) {
                $node = array(
                    'id' => $category['id'],
                    'cate_name' => $category['cate_name'],
                    'cate_parent_id' => $category['cate_parent_id'],
                    'cate_level' => $category['cate_level'],
                    'cate_order' => $category['cate_order'],
                    'parents' => $parents,
                    'children' => $this->buildCategoriesTree($categories, $category['id'], array_merge($parents, [$category['id']]))
                );              
    
                $tree[] = $node;
            }
        }
    
        return $tree;
    }
}