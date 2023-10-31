<?php

namespace App\Observers\Validators;

use App\Repositories\WordsRepo;

class WordsValidator
{    
    public function dupName($ws_name, $id)
    {      
        $WordsRepo = new WordsRepo();
        $rowDup = $WordsRepo->findByName($ws_name);
        if ($rowDup == null) {
            return true;
        }
        if ($id === null) {
            return false;
        }
        $row = $WordsRepo->find($id);
        if ($row['ws_name'] == $rowDup['ws_name']) {
            return true;
        }

        return false;
    }
}
