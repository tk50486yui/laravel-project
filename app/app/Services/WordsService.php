<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Processors\WordsProcessor;
use App\Services\Outputs\WordsOutput;
use App\Observers\WordsObserver;
use App\Observers\WordsTagsObserver;
use App\Repositories\WordsRepo;
use App\Repositories\WordsTagsRepo;

class WordsService
{
    public function find($id)
    {
        $WordsRepo = new WordsRepo();
        $WordsTagsRepo = new WordsTagsRepo();
        $WordsOutput = new WordsOutput();
        $result = $WordsRepo->find($id);
        if($result){
            $result->words_tags['values'] = $WordsTagsRepo->findByWordsID($id);
            $result = $WordsOutput->genWordsTags($result, false);
        }
        return $result;
    }

    public function findAll()
    {     
        $WordsRepo = new WordsRepo();
        $WordsOutput = new WordsOutput();
        $result = $WordsRepo->findAll();
        return $WordsOutput->genWordsTags($result, true);
    }    

    public function add($reqData)
    {      
        DB::transaction(function () use ($reqData){
            $WordsProcessor = new WordsProcessor();
            $WordsObserver = new WordsObserver();            
            $WordsTagsObserver = new WordsTagsObserver();
            $WordsRepo = new WordsRepo();
            $WordsTagsRepo = new WordsTagsRepo();
            $reqData = $WordsProcessor->populate($reqData);
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

    public function deleteByID($id)
    {     
        DB::transaction(function () use ($id){
            $WordsObserver = new WordsObserver();
            $WordsRepo = new WordsRepo();
            $WordsObserver->validate(array(), $id, false);
            $WordsRepo->deleteByID($id);
        });
    }
}