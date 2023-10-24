<?php

namespace App\Services;

use App\Repositories\WordsRepo;

class WordsService
{
    public function getAll()
    {     
        $WordsRepo = new WordsRepo();
        $result = $WordsRepo->getAll();   
    
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
}