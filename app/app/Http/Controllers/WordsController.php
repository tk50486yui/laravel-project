<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\Words\WordsRequest;
use App\Services\WordsService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use App\Exceptions\Custom\RecordNotFoundException;
use App\Exceptions\Custom\Responses\Messages;

class WordsController extends Controller
{
    public function find(Request $request, $id)
    {
        $WordsService = new WordsService();
       
        $result = $WordsService->find($id);
        if(!$result){
            throw new RecordNotFoundException();
        }       
       
        return response()->json($result);
    }

    public function findAll()
    {
        $WordsService = new WordsService();
        $result = $WordsService->findAll();
       
        return response()->json($result);
    }

    public function add(WordsRequest $request)
    { 
       
        $requestData = $request->validated();
        $WordsService = new WordsService();
        $WordsService->add($requestData);
        return Messages::Success();
        
        
    }
    
}
