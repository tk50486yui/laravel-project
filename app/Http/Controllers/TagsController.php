<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RedisService;
use App\Services\TagsService;
use App\Http\Requests\Tags\TagsRequest;
use App\Http\Requests\Tags\TagsOrderRequest;
use App\Exceptions\Custom\RecordNotFoundException;
use App\Exceptions\Custom\Responses\Messages;

class TagsController extends Controller
{
    protected $redis;
    protected $redisPrefix = 'Tags';

    public function __construct(RedisService $serv)
    {
        $this->redis = $serv;
    }

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
        return response()->json(
            $this->redis->cache(
                $this->redisPrefix, 
                __FUNCTION__,
                function () {
                    $TagsService = new TagsService();
                    return $TagsService->findAll();
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
                    $TagsService = new TagsService();
                    return $TagsService->findRecent();
                }
            )
        );
    }

    public function add(TagsRequest $request)
    {        
        $reqData = $request->validated();
        $TagsService = new TagsService();
        $TagsService->add($reqData);
        $this->redis->update($this->redisPrefix, $TagsService);
        return Messages::Success();
    }

    public function edit(TagsRequest $request, $id)
    {
        $reqData = $request->validated();
        $TagsService = new TagsService();
        $TagsService->edit($reqData, $id);
        $this->redis->update($this->redisPrefix, $TagsService);
        return Messages::Success();
    }

    public function editOrder(TagsOrderRequest $request)
    {
        $reqData = $request->validated();
        $TagsService = new TagsService();
        $TagsService->editOrder($reqData);
        $this->redis->update($this->redisPrefix, $TagsService);
        return Messages::Success();
    }

    public function deleteByID(Request $request, $id)
    {
        $TagsService = new TagsService();
        $TagsService->deleteByID($id);
        $this->redis->update($this->redisPrefix, $TagsService);
        return Messages::Deletion();
    }
    
}
