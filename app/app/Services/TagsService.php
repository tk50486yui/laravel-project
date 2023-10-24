<?php

namespace App\Services;

use App\Repositories\TagsRepo;

class TagsService
{
    public function getAll()
    {     
        $TagsRepo = new TagsRepo();
        $result = $TagsRepo->getAll();   
    
        return $result;
    }

    public function findAll()
    {     
        $TagsRepo = new TagsRepo();
        $result = $TagsRepo->findAll();
        $result = $this->buildTagsTree($result);
    
        return $result;
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