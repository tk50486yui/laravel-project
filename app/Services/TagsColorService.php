<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\TagsColorRepo;
use App\Repositories\TagsRepo;
use App\Observers\TagsColorObserver;

class TagsColorService
{
    public function find($id)
    {
        $TagsColorRepo = new TagsColorRepo();
        return $TagsColorRepo->find($id);
    }

    public function findAll()
    {
        $TagsColorRepo = new TagsColorRepo();
        return $TagsColorRepo->findAll();
    }  

    public function add($reqData)
    {
        DB::transaction(function () use ($reqData){
            $TagsColorObserver = new TagsColorObserver();
            $TagsColorRepo = new TagsColorRepo();
            $TagsColorObserver->validate($reqData, null);
            $TagsColorRepo->add($reqData);
        });
       
    }

    public function edit($reqData, $id)
    {
        DB::transaction(function () use ($reqData, $id){
            $TagsColorObserver = new TagsColorObserver();
            $TagsColorRepo = new TagsColorRepo();
            $TagsColorObserver->validate($reqData, $id);
            $TagsColorRepo->edit($reqData, $id);
        });
    }   

    public function deleteByID($id)
    {     
        DB::transaction(function () use ($id){
            $TagsColorObserver = new TagsColorObserver();
            $TagsColorRepo = new TagsColorRepo();
            $TagsRepo = new TagsRepo();
            $TagsColorObserver->validate(array(), $id, false);
            $TagsRepo->updateNullByTcID($id); // tags tc_id
            $TagsColorRepo->deleteByID($id);
        });
    }
}