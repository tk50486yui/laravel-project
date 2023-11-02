<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Articles\ArticlesRequest;
use App\Services\ArticlesService;
use App\Exceptions\Custom\RecordNotFoundException;
use App\Exceptions\Custom\Responses\Messages;

class ArticlesController extends Controller
{
    public function find(Request $request, $id)
    {
        $ArticlesService= new ArticlesService();
        $result = $ArticlesService->find($id);
        if(!$result){
            throw new RecordNotFoundException();
        }       
        return response()->json($result);
    }

    public function findAll(Request $request)
    {
        $ArticlesService= new ArticlesService();
        $result = $ArticlesService->findAll();
        return response()->json($result);
    }

    public function add(ArticlesRequest $request)
    {
        $reqData = $request->validated();
        $ArticlesService = new ArticlesService();
        $ArticlesService->add($reqData);
        return Messages::Success();
    }

    public function edit(ArticlesRequest $request, $id)
    {
        $reqData = $request->validated();
        $ArticlesService = new ArticlesService();
        $ArticlesService->edit($reqData, $id);
        return Messages::Success();
    }
}
