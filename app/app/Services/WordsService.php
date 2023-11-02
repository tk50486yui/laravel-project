<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Processors\WordsProcessor;
use App\Observers\WordsObserver;
use App\Observers\WordsTagsObserver;
use App\Repositories\WordsRepo;
use App\Repositories\WordsTagsRepo;

class WordsService
{
    public function find($id)
    {     
        $WordsTagsRepo = new WordsTagsRepo();
        $WordsRepo = new WordsRepo();
        $result = $WordsRepo->find($id);
        if($result){
            $result->words_tags['values'] = $WordsTagsRepo->findByWordsID($id);
            if(isset($result->words_tags['values']) && count($result->words_tags['values']) > 0){
                $result->words_tags['array'] = array();        
                foreach($result->words_tags['values'] as $item){
                    array_push($result->words_tags['array'], (string)$item->ts_id);                    
                }           
            }
        }

        return $result;
    }

    public function findAll()
    {     
        $WordsRepo = new WordsRepo();
        $result = $WordsRepo->findAll();  
        // words_tags['values'], words_tags['array']
        $i = 0;
        foreach($result as $item){
            if($item->words_tags != null){
                // decode words_tags['values']
                $result[$i]->words_tags = json_decode($item->words_tags, true);                           
                // create words_tags['array']
                if (isset($result[$i]->words_tags['values']) && count($result[$i]->words_tags['values']) > 0 ) {
                    $result[$i]->words_tags['array'] = array();
                    foreach($result[$i]->words_tags['values'] as $row){
                        array_push($result[$i]->words_tags['array'], (string)$row['ts_id']); 
                    }                      
                }else{
                    $result[$i]->words_tags['array'] = array();
                }
            }                        
            $i++;  
        }    
    
        return $result;
    }

    public function add($reqData)
    {      
        DB::transaction(function () use ($reqData){
            $WordsProcessor = new WordsProcessor();
            $WordsObserver = new WordsObserver();            
            $WordsTagsObserver = new WordsTagsObserver();
            $WordsRepo = new WordsRepo();
            $WordsTagsRepo = new WordsTagsRepo();
            $WordsObserver->validate($reqData, null);
            $array_ts_id = $WordsProcessor->begin($reqData);
            $id = $WordsRepo->add($reqData);
            if($array_ts_id){
                foreach($array_ts_id as $item){
                    $new = array();
                    $new['ws_id'] = $id;
                    $new['ts_id'] = $item;
                    $WordsTagsObserver->validate($new, null);
                    $WordsTagsRepo->add($new);
                }
            }
        });
       
    }

    public function edit($reqData, $id)
    {
        DB::transaction(function () use ($reqData, $id){
            $WordsProcessor = new WordsProcessor();
            $WordsObserver = new WordsObserver();
            $WordsTagsObserver = new WordsTagsObserver();
            $WordsRepo = new WordsRepo();
            $WordsTagsRepo = new WordsTagsRepo();
            $WordsObserver->validate($reqData, $id);
            $array_ts_id = $WordsProcessor->begin($reqData); 
            $WordsRepo->edit($reqData, $id);
            if($array_ts_id){
                $WordsTagsRepo->deleteByWsID($id);
                foreach($array_ts_id as $item){
                    $new = array();
                    $new['ws_id'] = $id;
                    $new['ts_id'] = $item;
                    $WordsTagsObserver->validate($new, null);
                    $WordsTagsRepo->add($new);
                }
            }else{
                $WordsTagsRepo->deleteByWsID($id);
            }
        });
       
    }

    public function editCommon($reqData, $id)
    {
        DB::transaction(function () use ($reqData, $id){
            $WordsObserver = new WordsObserver();
            $WordsRepo = new WordsRepo();
            $WordsObserver->validate($reqData, $id, false);
            $WordsRepo->editCommon($reqData, $id);
        });       
    }

    public function editImportant($reqData, $id)
    {
        DB::transaction(function () use ($reqData, $id){
            $WordsObserver = new WordsObserver();
            $WordsRepo = new WordsRepo();
            $WordsObserver->validate($reqData, $id, false);
            $WordsRepo->editImportant($reqData, $id);
        });
       
    }
}