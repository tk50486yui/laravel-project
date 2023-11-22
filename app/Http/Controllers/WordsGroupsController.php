<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\WordsGroups\WordsGroupsRequest;
use App\Services\WordsGroupsService;
use App\Exceptions\Custom\RecordNotFoundException;
use App\Exceptions\Custom\Responses\Messages;

class WordsGroupsController extends Controller
{
    public function find(Request $request, $id)
    {
        $WordsGroupsService = new WordsGroupsService();
        $result = $WordsGroupsService->find($id);
        if(!$result){
            throw new RecordNotFoundException();
        }
       
        return response()->json($result);
    }

    public function findAll()
    {
        $WordsGroupsService = new WordsGroupsService();
        $result = $WordsGroupsService->findAll();
       
        return response()->json($result);
    }

    public function add(WordsGroupsRequest $request)
    {
        $reqData = $request->validated();
        $WordsGroupsService = new WordsGroupsService();
        $WordsGroupsService->add($reqData);
        return Messages::Success();
    }

    public function edit(WordsGroupsRequest $request, $id)
    {
        $reqData = $request->validated();
        $WordsGroupsService = new WordsGroupsService();
        $WordsGroupsService->edit($reqData, $id);
        return Messages::Success();
    }

    public function deleteByID(Request $request, $id)
    {
        $WordsGroupsService = new WordsGroupsService();
        $WordsGroupsService->deleteByID($id);
        return Messages::Success();
    }
}
