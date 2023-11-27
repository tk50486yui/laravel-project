<?php

namespace App\Exceptions\Custom\Responses;

class Messages
{ 
    public static function Success()
    {
        return response()->json(['error' => ''], 200);
    }
    public static function Deletion()
    {
        return response()->json(['error' => ''], 204);
    }
    // 404
    public static function RecordNotFound()
    {
        return response()->json(['error' => 'Record not found.'], 404);
    }
    // 409
    public static function Duplicate()
    {
        return response()->json(['error' => 'Duplicate data.'], 409);
    }
    // 422
    public static function ProcessingFailed()
    {
        return response()->json(['error' => 'Data processing failed.'], 422);
    }
    // 422
    public static function InvalidData()
    {
        return response()->json(['error' => 'Invalid data.'], 422);
    }
    // 422
    public static function InvalidForeignKey()
    {
        return response()->json(['error' => 'Invalid foreign key.'], 422);
    }
    // 422
    public static function InvalidGivenData()
    {
        return response()->json(['error' => 'Invalid request data.'], 422);
    }

    

}
