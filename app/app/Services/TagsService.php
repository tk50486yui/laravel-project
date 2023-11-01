<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\TagsRepo;
use App\Observers\TagsObserver;
use App\Services\Processors\TagsProcessor;

class TagsService
{
    public function getAll()
    {     
        $TagsRepo = new TagsRepo();
        $result = $TagsRepo->getAll();   
    
        return $result;
    }

    public function find($id)
    {     
        $TagsRepo = new TagsRepo();
        $result = $TagsRepo->find($id);    
    
        return $result;
    }

    public function findAll()
    {     
        $TagsRepo = new TagsRepo();
        $result = $TagsRepo->findAll();
        $result = $TagsRepo->buildTagsTree($result);
    
        return $result;
    }

    public function findRecent()
    {     
        $TagsRepo = new TagsRepo();
        $result = $TagsRepo->findRecent();      
    
        return $result;
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
}