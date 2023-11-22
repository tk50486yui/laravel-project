<?php

namespace App\Services\Processors;

/**   
 *  幫助 Service 處理較複雜的客製資料
 **/

class CategoriesProcessor
{
    public function populate($data)
    {       
        $data['cate_name'] = $data['cate_name'] ?? null;
        $data['cate_parent_id'] = $data['cate_parent_id'] ?? null;

        return $data;
    }

    public function setLevel($CategoriesRepo, $reqData){
        if(isset($reqData['cate_parent_id']) && $reqData['cate_parent_id'] != null){
            $parent = $CategoriesRepo->find($reqData['cate_parent_id']);
            return $parent->cate_level + 1;
        }else{
            return 1;
        } 
    }

    public function setOrder($CategoriesRepo, $reqData, $id = null){
        if(isset($reqData['cate_parent_id']) && $reqData['cate_parent_id'] != null){
            if($id){
                $single = $CategoriesRepo->find($id);
                if(!$single->cate_parent_id){
                    return $reqData['cate_order'];
                }
            }
            $children = $CategoriesRepo->findMaxOrderByParent($reqData['cate_parent_id']);
            if($children->sibling_count == 0){
                return 0;
            }else{
                return $children->max_cate_order + 1;
            }                
        }else{
            if($id){
                $single = $CategoriesRepo->find($id);
                if($single->cate_parent_id == null || $single->cate_parent_id == ''){
                    return $single->cate_order;
                }
            }
            $sibling = $CategoriesRepo->findOrderInFirstLevel();
            if($sibling && $sibling != null){
                return $sibling->max_cate_order + 1;
            }else{
                return 0;
            }
        }
    }
}
