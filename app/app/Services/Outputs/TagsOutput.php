<?php

namespace App\Services\Outputs;

/**
 *     輸出資料處理
 **/

class TagsOutput
{
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