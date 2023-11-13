<?php

namespace App\Services\Outputs;

/**
 *     輸出資料處理
 **/

class CategoriesOutput
{
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