<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TagsService;
use App\Http\Requests\Tags\TagsRequest;
use App\Exceptions\Custom\RecordNotFoundException;
use App\Exceptions\Custom\Responses\Messages;

class TagsController extends Controller
{
    public function find(Request $request, $id)
    {
        $TagsService = new TagsService();
        $result = $TagsService->find($id);
        if(!$result){
            throw new RecordNotFoundException();
        }
       
        return response()->json($result);
    }

    public function findAll()
    {
        $TagsService = new TagsService();
        $result = $TagsService->findAll();
       
        return response()->json($result);
    }

    public function findRecent()
    {     
        $TagsService = new TagsService();
        $result = $TagsService->findRecent();      
    
        return response()->json($result);
    }

    public function add(TagsRequest $request)
    {
        $TagsService = new TagsService();
        $TagsService->add($request);
        return Messages::Success();
    }

    public function edit(TagsRequest $request, $id)
    {
        $TagsService = new TagsService();
        $TagsService->edit($request, $id);
        return Messages::Success();
    }
    
}
