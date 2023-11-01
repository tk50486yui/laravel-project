<?php

namespace App\Services\Processors;

/**   
 *  幫助 Service 處理較複雜的客製資料
 **/

class CategoriesProcessor
{   
    public function setCateLevel($CategoriesRepo, $reqData){
        if($reqData['cate_parent_id'] != null){
            $parent = $CategoriesRepo->find($reqData['cate_parent_id']);
            return $parent->cate_level + 1;
        }else{
            return 1;
        } 
    }

    public function setCateOrder($CategoriesRepo, $reqData){
        if($reqData['cate_parent_id'] != null){
            $children = $CategoriesRepo->findMaxOrderByParent($reqData['cate_parent_id']);
            if($children->sibling_count == 0){
                return 0;
            }else{
                return $children->max_cate_order + 1;
            }                
        }else{
            $sibling = $CategoriesRepo->findOrderInFirstLevel();
            if($sibling && $sibling != null){
                return $sibling->max_cate_order + 1;
            }else{
                return 0;
            }
        }
    }
}
