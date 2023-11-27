<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Categories\CategoriesRequest;
use App\Http\Requests\Categories\CategoriesOrderRequest;
use App\Services\RedisService;
use App\Services\CategoriesService;
use App\Exceptions\Custom\RecordNotFoundException;
use App\Exceptions\Custom\Responses\Messages;

class CategoriesController extends Controller
{
    protected $redis;
    protected $redisPrefix = 'Categories';

    public function __construct(RedisService $serv)
    {
        $this->redis = $serv;
    }

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
        return response()->json(
            $this->redis->cache(
                $this->redisPrefix, 
                __FUNCTION__,
                function () {
                    $CategoriesService= new CategoriesService();
                    return $CategoriesService->findAll();
                }
            )
        );
    }

    public function findRecent()
    {     
        return response()->json(
            $this->redis->cache(
                $this->redisPrefix, 
                __FUNCTION__,
                function () {
                    $CategoriesService = new CategoriesService();
                    return $CategoriesService->findRecent();
                }
            )
        );
    }

    public function add(CategoriesRequest $request)
    {        
        $reqData = $request->validated();
        $CategoriesService = new CategoriesService();
        $CategoriesService->add($reqData);
        $this->redis->update($this->redisPrefix, $CategoriesService);
        return Messages::Success();
    }

    public function edit(CategoriesRequest $request, $id)
    {        
        $reqData = $request->validated();
        $CategoriesService = new CategoriesService();
        $CategoriesService->edit($reqData, $id);
        $this->redis->update($this->redisPrefix, $CategoriesService);
        return Messages::Success();
    }

    public function editOrder(CategoriesOrderRequest $request)
    {        
        $reqData = $request->validated();
        $CategoriesService = new CategoriesService();
        $CategoriesService->editOrder($reqData);
        $this->redis->update($this->redisPrefix, $CategoriesService);
        return Messages::Success();
    }

    public function deleteByID(Request $request, $id)
    {
        $CategoriesService = new CategoriesService();
        $CategoriesService->deleteByID($id);
        $this->redis->update($this->redisPrefix, $CategoriesService);
        return Messages::Success();
    }
}
