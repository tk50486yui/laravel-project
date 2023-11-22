<?php

namespace App\Validators\ModelValidators;

use App\Repositories\TagsRepo;
use App\Services\Outputs\TagsOutput;

class TagsModelValidator
{
    public function checkID($id)
    {      
        $TagsRepo = new TagsRepo();
        $result = $TagsRepo->find($id); 
        if(!$result){
            return false;
        }
        return true;
    }

    public function parentID($ts_parent_id)
    {      
        $TagsRepo = new TagsRepo();
        $result = $TagsRepo->find($ts_parent_id); 
        if(!$result){
            return false;
        }
        return true;
    }

    public function dupName($ts_name, $id)
    {      
        $TagsRepo = new TagsRepo();
        $rowDup = $TagsRepo->findByName($ts_name);
        if ($rowDup == null) {
            return true;
        }
        if ($id === null) {
            return false;
        }
        $row = $TagsRepo->find($id);
        if ($row->ts_name == $rowDup['ts_name']) {
            return true;
        }

        return false;
    }

    // 檢查樹狀資料
    public function validateTree($ts_parent_id, $id)
    {
        $TagsRepo = new TagsRepo();
        $TagsOutput = new TagsOutput();
        if ($ts_parent_id == $id) {
            return false;
        }      
        // 檢查所新增之 ts_parent_id 是否為自己的子節點 有值才做
        if ($ts_parent_id != null || $ts_parent_id != '') {
            $result = $TagsRepo->findCheckParent($id, $ts_parent_id);
            if($result != null || count($result) > 0){
                return false;
            }
        }      
        // 透過樹狀檢查子類別
        $all = $TagsRepo->findAll();
        $all = array_map('get_object_vars', $all);
        $tree = $TagsOutput->buildTagsTree($all);
        if ($this->validateParent($tree, $id, $ts_parent_id)) {
            return false;
        }

        return true;
    }

    //  檢查所新增的節點是否為子節點 避免出現問題 true => 不合法 false => 合法
    public function validateParent($tree, $id, $ts_parent_id)
    {
        foreach ($tree as $node) {
            if ($node['id'] == $ts_parent_id) {
                return in_array($id, $node['parents']);
            } else {
                if ($this->validateParent($node['children'], $id, $ts_parent_id)) {
                    return true;
                }
            }
        }

        return false;
    }
}
