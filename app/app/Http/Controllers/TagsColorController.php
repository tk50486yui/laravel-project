<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TagsColorService;
use App\Http\Requests\TagsColor\TagsColorRequest;
use App\Exceptions\Custom\RecordNotFoundException;
use App\Exceptions\Custom\Responses\Messages;

class TagsColorController extends Controller
{
    public function find(Request $request, $id)
    {
        $TagsColorService = new TagsColorService();
        $result = $TagsColorService->find($id);
        if(!$result){
            throw new RecordNotFoundException();
        }
       
        return response()->json($result);
    }

    public function findAll()
    {
        $TagsColorService = new TagsColorService();
        $result = $TagsColorService->findAll();
       
        return response()->json($result);
    }   

    public function add(TagsColorRequest $request)
    {        
        $reqData = $request->validated();
        $TagsColorService = new TagsColorService();
        $TagsColorService->add($reqData);
        return Messages::Success();
    }

    public function edit(TagsColorRequest $request, $id)
    {
        $reqData = $request->validated();
        $TagsColorService = new TagsColorService();
        $TagsColorService->edit($reqData, $id);
        return Messages::Success();
    }    

    public function deleteByID(Request $request, $id)
    {
        $TagsColorService = new TagsColorService();
        $TagsColorService->deleteByID($id);
        return Messages::Success();
    }
    
}
