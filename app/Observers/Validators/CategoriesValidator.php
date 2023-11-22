<?php

namespace App\Observers\Validators;

use App\Repositories\CategoriesRepo;
use App\Services\Outputs\CategoriesOutput;

class CategoriesValidator
{
    public function checkID($id)
    {      
        $CategoriesRepo = new CategoriesRepo();
        $result = $CategoriesRepo->find($id); 
        if(!$result){
            return false;
        }
        return true;
    }

    public function parentID($cate_parent_id)
    {      
        $CategoriesRepo = new CategoriesRepo();
        $result = $CategoriesRepo->find($cate_parent_id); 
        if(!$result){
            return false;
        }
        return true;
    }

    public function dupName($cate_name, $id)
    {      
        $CategoriesRepo = new CategoriesRepo();
        $rowDup = $CategoriesRepo->findByName($cate_name);
        if ($rowDup == null) {
            return true;
        }
        if ($id === null) {
            return false;
        }
        $row = $CategoriesRepo->find($id);
        if ($row->cate_name == $rowDup['cate_name']) {
            return true;
        }

        return false;
    }

    // 檢查樹狀資料
    public function validateTree($cate_parent_id, $id)
    {
        $CategoriesRepo = new CategoriesRepo();
        $CategoriesOutput = new CategoriesOutput();
        if ($cate_parent_id == $id) {
            return false;
        }      
        // 檢查所新增之 cate_parent_id 是否為自己的子節點 有值才做
        if ($cate_parent_id != null || $cate_parent_id != '') {
            $result = $CategoriesRepo->findCheckParent($id, $cate_parent_id);           
            if($result != null || count($result) > 0){               
                return false;
            }
        }
        // 透過樹狀檢查子類別
        $all = $CategoriesRepo->findAll();
        $all = array_map('get_object_vars', $all);
        $tree = $CategoriesOutput->buildCategoriesTree($all);
        if ($this->validateParent($tree, $id, $cate_parent_id)) {
            return false;
        }

        return true;
    }

    //  檢查所新增的節點是否為子節點 避免出現問題 true => 不合法 false => 合法
    public function validateParent($tree, $id, $cate_parent_id)
    {
        foreach ($tree as $node) {
            if ($node['id'] == $cate_parent_id) {
                return in_array($id, $node['parents']);
            } else {
                if ($this->validateParent($node['children'], $id, $cate_parent_id)) {
                    return true;
                }
            }
        }

        return false;
    }
}
