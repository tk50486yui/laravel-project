<?php

namespace App\Exceptions\Custom\Responses;

class Messages
{  
    public static function InvalidGivenData()
    {
        return response()->json(['error' => 'The given data was invalid.'], 422);
    }
 
    public static function RecordNotFound()
    {
        return response()->json(['error' => 'Record not found.'], 404);
    }

}
