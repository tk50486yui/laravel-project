<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Processors\WordsGroupsProcessor;
use App\Observers\WordsGroupsObserver;
use App\Observers\WordsGroupsDetailsObserver;
use App\Repositories\WordsGroupsRepo;
use App\Repositories\WordsGroupsDetailsRepo;

class WordsGroupsService
{
    public function find($id)
    {        
        $WordsGroupsDetailsRepo = new WordsGroupsDetailsRepo();
        return $WordsGroupsDetailsRepo->findByWgID($id);
    }

    public function findAll()
    {
        $WordsGroupsRepo = new WordsGroupsRepo();
        $WordsGroupsDetailsRepo = new WordsGroupsDetailsRepo();
        $result = $WordsGroupsRepo->findAll();
        $i=0;
        if(count($result) > 0){
            foreach($result as $item){
                $result[$i]['details'] = $WordsGroupsDetailsRepo->findByWgID($item->id);
                $i++;
            }
        }

        return $result;
    }

    public function add($reqData)
    {        
        DB::transaction(function () use ($reqData){
            $WordsGroupsProcessor = new WordsGroupsProcessor();
            $WordsGroupsObserver = new WordsGroupsObserver();            
            $WordsGroupsDetailsObserver = new WordsGroupsDetailsObserver();
            $WordsGroupsRepo = new WordsGroupsRepo();
            $WordsGroupsDetailsRepo = new WordsGroupsDetailsRepo();
            $WordsGroupsObserver->validate($reqData, null);
            $wgd_array = $WordsGroupsProcessor->begin($reqData);
            $id = $WordsGroupsRepo->add($reqData);
            if($wgd_array){
                foreach($wgd_array as $item){
                    $new = array();
                    $new['wg_id'] = $id;
                    $new['ws_id'] = $item;
                    $WordsGroupsDetailsObserver->validate($new, null);
                    $WordsGroupsDetailsRepo->add($new);
                }
            }
        });
    }

    public function edit($reqData, $id)
    {        
        DB::transaction(function () use ($reqData, $id){
            $WordsGroupsProcessor = new WordsGroupsProcessor();
            $WordsGroupsObserver = new WordsGroupsObserver();            
            $WordsGroupsDetailsObserver = new WordsGroupsDetailsObserver();
            $WordsGroupsRepo = new WordsGroupsRepo();
            $WordsGroupsDetailsRepo = new WordsGroupsDetailsRepo();
            $WordsGroupsObserver->validate($reqData, $id);
            $wgd_array = $WordsGroupsProcessor->begin($reqData);
            $WordsGroupsRepo->edit($reqData, $id);
            if($wgd_array){
                $WordsGroupsDetailsRepo->deleteByWgID($id);
                foreach($wgd_array as $item){
                    $new = array();
                    $new['wg_id'] = $id;
                    $new['ws_id'] = $item;
                    $WordsGroupsDetailsObserver->validate($new, null);
                    $WordsGroupsDetailsRepo->add($new);
                }
            }else{
                $WordsGroupsDetailsRepo->deleteByWgID($id);
            }
        });
    }

    public function deleteByID($id)
    {     
        DB::transaction(function () use ($id){
            $WordsGroupsObserver = new WordsGroupsObserver();
            $WordsGroupsRepo = new WordsGroupsRepo();
            $WordsGroupsObserver->validate(array(), $id, false);
            $WordsGroupsRepo->deleteByID($id);
        });
    }
}