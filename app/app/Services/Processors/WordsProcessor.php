<?php

namespace App\Services\Processors;

/**   
 *  幫助 Service 處理較複雜的資料欄位
 **/

class WordsProcessor
{   
    private $wordsTags;

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function begin($data){
        $this->validateWordsTags($data);
        if($this->wordsTags == null){
            return false;
        }
        return $this->FilterDupArray($this->wordsTags);
    }

    public function validateWordsTags($data)
    {
        if(isset($data['words_tags']['array']) && !is_bool($data['words_tags']['array'])){
            if(!is_array($data['words_tags']['array']) || empty($data['words_tags']['array'])){
                $this->wordsTags = null;
            }else{
                $this->wordsTags = $data['words_tags']['array'];
            }
        }else{
            $this->wordsTags = null;
        }   
    }
    
    public function FilterDupArray($data)
    {  
        $output = array();
        $seen = array();
        foreach($data as $item){          
            // 避免重複資料         
            if (!in_array($item, $seen)) {
                array_push($output, $item);   
                array_push($seen, $item);
            }  
        }

        return $output;
    }
}
