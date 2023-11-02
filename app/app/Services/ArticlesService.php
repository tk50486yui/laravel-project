<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Observers\ArticlesObserver;
use App\Observers\ArticlesTagsObserver;
use App\Services\Processors\ArticlesProcessor;
use App\Repositories\ArticlesRepo;
use App\Repositories\ArticlesTagsRepo;

class ArticlesService
{
    public function find($id)
    {     
        $ArticlesRepo = new ArticlesRepo();
        $ArticlesTagsRepo = new ArticlesTagsRepo();
        $result = $ArticlesRepo->find($id);
        $result['articles_tags']['values'] = $ArticlesTagsRepo->findByArtiID($id);
        if(isset($result['articles_tags']['values']) && count($result['articles_tags']['values']) > 0){
            $result['articles_tags']['array'] = array();
            foreach($result['articles_tags']['values'] as $item){
                array_push($result['articles_tags']['array'], (string)$item->ts_id);                    
            }
        } 
    
        return $result;
    }

    public function findAll()
    {     
        $ArticlesRepo = new ArticlesRepo();
        $result = $ArticlesRepo->findAll();
        // articles_tags['values'], articles_tags['array']
        $i = 0;
        foreach($result as $item){
            if($item->articles_tags != null){
                // decode articles_tags['values']
                $result[$i]->articles_tags = json_decode($item->articles_tags, true);
                // create articles_tags['array']
                if (isset($result[$i]->articles_tags['values']) && count($result[$i]->articles_tags['values']) > 0 ) {
                    $result[$i]->articles_tags['array'] = array();
                    foreach($result[$i]->articles_tags['values'] as $row){
                        array_push($result[$i]->articles_tags['array'], (string)$row['ts_id']); 
                    }                      
                }else{
                    $result[$i]->articles_tags['array'] = array();
                }                   
            }              
            $i++;  
        }
    
        return $result;
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