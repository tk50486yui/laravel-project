<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\WordsRequest;
use App\Services\WordsService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;


class WordsController extends Controller
{
    public function find(Request $request, $id)
    {
        $WordsService = new WordsService();
        try{
            $result = $WordsService->find($id);
            if(!$result){
                throw new ModelNotFoundException();
            }
        }
        catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Record not found'], 404);
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
        try{           
            $requestData = $request->validated();
            return response()->json($requestData, 200);
            $WordsService = new WordsService();
           // $result = $WordsService->add($requestData);
        }catch (ValidationException $e){          
            return response()->json(['error' => $e->getMessage()], 500);
        }catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        
       
        //return response()->json($result);
    }
    
}
