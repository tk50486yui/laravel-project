<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Repositories\CategoriesRepo;
use App\Observers\CategoriesObserver;
use App\Services\Processors\CategoriesProcessor;

class CategoriesService
{
    public function getAll()
    {     
        $CategoriesRepo = new CategoriesRepo();
        $result = $CategoriesRepo->getAll();   
    
        return $result;
    }

    public function find($id)
    {     
        $CategoriesRepo = new CategoriesRepo();
        $result = $CategoriesRepo->find($id);       
    
        return $result;
    }

    public function findAll()
    {     
        $CategoriesRepo = new CategoriesRepo();
        $result = $CategoriesRepo->findAll();
        $result = $CategoriesRepo->buildCategoriesTree($result);
    
        return $result;
    }

    public function findRecent()
    {     
        $CategoriesRepo = new CategoriesRepo();
        $result = $CategoriesRepo->findRecent();      
    
        return $result;
    }

    public function add($reqData)
    {     
        DB::transaction(function () use ($reqData){
            $CategoriesObserver = new CategoriesObserver();
            $CategoriesProcessor = new CategoriesProcessor();
            $CategoriesRepo = new CategoriesRepo();
            $CategoriesObserver->validate($reqData, null);
            $reqData['cate_level'] = $CategoriesProcessor->setCateLevel($CategoriesRepo,$reqData);
            $reqData['cate_order'] = $CategoriesProcessor->setCateOrder($CategoriesRepo,$reqData);
            $CategoriesRepo->add($reqData);
        });        
    }

    public function edit($reqData, $id)
    {     
        DB::transaction(function () use ($reqData, $id){
            $CategoriesObserver = new CategoriesObserver();
            $CategoriesProcessor = new CategoriesProcessor();
            $CategoriesRepo = new CategoriesRepo();
            $CategoriesObserver->validate($reqData, $id);
            $reqData['cate_level'] = $CategoriesProcessor->setCateLevel($CategoriesRepo,$reqData);
            $reqData['cate_order'] = $CategoriesProcessor->setCateOrder($CategoriesRepo,$reqData);
            $CategoriesRepo->edit($reqData, $id);
        });        
    }
    
}