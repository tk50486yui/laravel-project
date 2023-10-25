<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\WordsGroupsDetails;

class WordsGroupsDetailsRepo
{
    public function getAll()
    {
     
        $result = WordsGroupsDetails::all();   
    
        return $result;
    }

    public function findByWgID($wg_id)
    {
        $query ="SELECT 
                    ws.ws_name as ws_name, wgd.*
                FROM 
                    words_groups_details wgd
                LEFT JOIN 
                    words ws ON wgd.ws_id =  ws.id
                WHERE 
                    wgd.wg_id = ? 
                ORDER BY
                    ws.created_at DESC";

        $result = DB::select($query, array($wg_id));

        return $result;       
    }
}