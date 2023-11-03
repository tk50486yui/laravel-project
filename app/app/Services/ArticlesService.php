<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Processors\ArticlesProcessor;
use App\Services\Outputs\ArticlesOutput;
use App\Observers\ArticlesObserver;
use App\Observers\ArticlesTagsObserver;
use App\Repositories\ArticlesRepo;
use App\Repositories\ArticlesTagsRepo;

class ArticlesService
{
    public function find($id)
    {     
        $ArticlesRepo = new ArticlesRepo();
        $ArticlesTagsRepo = new ArticlesTagsRepo();
        $ArticlesOutput = new ArticlesOutput();
        $result = $ArticlesRepo->find($id);
        if($result){
            $result->articles_tags['values'] = $ArticlesTagsRepo->findByArtiID($id);
            $result = $ArticlesOutput->genArticlesTags($result, false);
        }
    
        return $result;
    }

    public function findAll()
    {     
        $ArticlesRepo = new ArticlesRepo();
        $result = $ArticlesRepo->findAll();
        $ArticlesOutput = new ArticlesOutput();
        return $ArticlesOutput->genArticlesTags($result, true);
    }
    public function add($reqData)
    { 
        DB::transaction(function () use ($reqData){
            $ArticlesProcessor = new ArticlesProcessor();
            $ArticlesObserver = new ArticlesObserver();
            $ArticlesTagsObserver = new ArticlesTagsObserver();
            $ArticlesRepo = new ArticlesRepo();
            $ArticlesTagsRepo = new ArticlesTagsRepo();
            $ArticlesObserver->validate($reqData, null);
            $array_ts_id = $ArticlesProcessor->begin($reqData);
            $id = $ArticlesRepo->add($reqData);
            if($array_ts_id){
                foreach($array_ts_id as $item){
                    $new = array();
                    $new['arti_id'] = $id;
                    $new['ts_id'] = $item;
                    $ArticlesTagsObserver->validate($new, null);
                    $ArticlesTagsRepo->add($new);
                }
            }
        });
    }

    public function edit($reqData, $id)
    { 
        DB::transaction(function () use ($reqData, $id){
            $ArticlesProcessor = new ArticlesProcessor();
            $ArticlesObserver = new ArticlesObserver();
            $ArticlesTagsObserver = new ArticlesTagsObserver();
            $ArticlesRepo = new ArticlesRepo();
            $ArticlesTagsRepo = new ArticlesTagsRepo();
            $ArticlesObserver->validate($reqData, $id);
            $array_ts_id = $ArticlesProcessor->begin($reqData);
            $ArticlesRepo->edit($reqData, $id);
            if($array_ts_id){
                $ArticlesTagsRepo->deleteByArtiID($id);
                foreach($array_ts_id as $item){
                    $new = array();
                    $new['arti_id'] = $id;
                    $new['ts_id'] = $item;
                    $ArticlesTagsObserver->validate($new, null);
                    $ArticlesTagsRepo->add($new);
                }
            }else{
                $ArticlesTagsRepo->deleteByArtiID($id);
            }
        });
    }
}