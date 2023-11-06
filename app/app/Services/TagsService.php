<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Processors\TagsProcessor;
use App\Services\Outputs\TagsOutput;
use App\Observers\TagsObserver;
use App\Repositories\TagsRepo;

class TagsService
{
    public function find($id)
    {
        $TagsRepo = new TagsRepo();
        return $TagsRepo->find($id);
    }

    public function findAll()
    {
        $TagsRepo = new TagsRepo();
        $TagsOutput = new TagsOutput();
        $result = $TagsRepo->findAll();
        return $TagsOutput->buildTagsTree($result);
    }

    public function findRecent()
    {     
        $TagsRepo = new TagsRepo();
        return $TagsRepo->findRecent();
    }  

    public function add($reqData)
    {
        DB::transaction(function () use ($reqData){
            $TagsObserver = new TagsObserver();
            $TagsProcessor = new TagsProcessor();
            $TagsRepo = new TagsRepo();
            $TagsObserver->validate($reqData, null);
            $reqData['ts_level'] = $TagsProcessor->setTsLevel($TagsRepo, $reqData);
            $reqData['ts_order'] = $TagsProcessor->setTsOrder($TagsRepo, $reqData);
            $TagsRepo->add($reqData);
        });
       
    }

    public function edit($reqData, $id)
    {
        DB::transaction(function () use ($reqData, $id){
            $TagsObserver = new TagsObserver();
            $TagsProcessor = new TagsProcessor();
            $TagsRepo = new TagsRepo();
            $TagsObserver->validate($reqData, $id);
            $reqData['ts_level'] = $TagsProcessor->setTsLevel($TagsRepo, $reqData);
            $reqData['ts_order'] = $TagsProcessor->setTsOrder($TagsRepo, $reqData);
            $TagsRepo->edit($reqData, $id);
        });
    }

    public function editOrder($reqData)
    {
        DB::transaction(function () use ($reqData){
            $TagsObserver = new TagsObserver();      
            $TagsRepo = new TagsRepo();
            foreach($reqData as $item){
                $TagsObserver->validate($item, $item['id'], false);
                $TagsRepo->editOrder($item['ts_order'], $item['id']);
            }
        });
    }

    public function deleteByID($id)
    {     
        DB::transaction(function () use ($id){
            $TagsRepo = new TagsRepo();
            $TagsRepo->deleteByID($id);
        });
    }
}