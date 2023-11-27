<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RedisService;
use App\Services\TagsColorService;
use App\Http\Requests\TagsColor\TagsColorRequest;
use App\Exceptions\Custom\RecordNotFoundException;
use App\Exceptions\Custom\Responses\Messages;

class TagsColorController extends Controller
{
    protected $redis;
    protected $redisPrefix = 'TagsColor';

    public function __construct(RedisService $serv)
    {
        $this->redis = $serv;
    }

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
        return response()->json(
            $this->redis->cache(
                $this->redisPrefix, 
                __FUNCTION__,
                function () {
                    $TagsColorService = new TagsColorService();
                    return $TagsColorService->findAll();
                }
            )
        );
    }   

    public function add(TagsColorRequest $request)
    {        
        $reqData = $request->validated();
        $TagsColorService = new TagsColorService();
        $TagsColorService->add($reqData);
        $this->redis->update($this->redisPrefix, $TagsColorService);
        return Messages::Success();
    }

    public function edit(TagsColorRequest $request, $id)
    {
        $reqData = $request->validated();
        $TagsColorService = new TagsColorService();
        $TagsColorService->edit($reqData, $id);
        $this->redis->update($this->redisPrefix, $TagsColorService);
        return Messages::Success();
    }    

    public function deleteByID(Request $request, $id)
    {
        $TagsColorService = new TagsColorService();
        $TagsColorService->deleteByID($id);
        $this->redis->update($this->redisPrefix, $TagsColorService);
        return Messages::Deletion();
    }
    
}
