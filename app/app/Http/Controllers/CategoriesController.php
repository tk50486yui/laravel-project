<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Categories\CategoriesRequest;
use App\Http\Requests\Categories\CategoriesOrderRequest;
use App\Services\CategoriesService;
use App\Exceptions\Custom\RecordNotFoundException;
use App\Exceptions\Custom\Responses\Messages;

class CategoriesController extends Controller
{
    public function find(Request $request, $id)
    {
        $CategoriesService= new CategoriesService();
        $result = $CategoriesService->find($id);
        if(!$result){
            throw new RecordNotFoundException();
        }
       
        return response()->json($result);
    }

    public function findAll()
    {
        $CategoriesService= new CategoriesService();
        $result = $CategoriesService->findAll();
       
        return response()->json($result);
    }

    public function findRecent()
    {     
        $CategoriesService = new CategoriesService();
        $result = $CategoriesService->findRecent();
    
        return response()->json($result);
    }

    public function add(CategoriesRequest $request)
    {        
        $reqData = $request->validated();
        $CategoriesService = new CategoriesService();
        $CategoriesService->add($reqData);
        return Messages::Success();
    }

    public function edit(CategoriesRequest $request, $id)
    {        
        $reqData = $request->validated();
        $CategoriesService = new CategoriesService();
        $CategoriesService->edit($reqData, $id);
        return Messages::Success();
    }

    public function editOrder(CategoriesOrderRequest $request)
    {        
        $reqData = $request->validated();
        $CategoriesService = new CategoriesService();
        $CategoriesService->editOrder($reqData);
        return Messages::Success();
    }
}
