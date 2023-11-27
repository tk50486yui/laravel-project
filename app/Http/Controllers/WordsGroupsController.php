<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\WordsGroups\WordsGroupsRequest;
use App\Services\RedisService;
use App\Services\WordsGroupsService;
use App\Exceptions\Custom\RecordNotFoundException;
use App\Exceptions\Custom\Responses\Messages;

class WordsGroupsController extends Controller
{
    protected $redis;
    protected $redisPrefix = 'WordsGroups';

    public function __construct(RedisService $serv)
    {
        $this->redis = $serv;
    }

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
        return response()->json(
            $this->redis->cache(
                $this->redisPrefix, 
                __FUNCTION__,
                function () {
                    $WordsGroupsService = new WordsGroupsService();
                    return $WordsGroupsService->findAll();
                }
            )
        );
    }

    public function add(WordsGroupsRequest $request)
    {
        $reqData = $request->validated();
        $WordsGroupsService = new WordsGroupsService();
        $WordsGroupsService->add($reqData);
        $this->redis->update($this->redisPrefix, $WordsGroupsService);
        return Messages::Success();
    }

    public function edit(WordsGroupsRequest $request, $id)
    {
        $reqData = $request->validated();
        $WordsGroupsService = new WordsGroupsService();
        $WordsGroupsService->edit($reqData, $id);
        $this->redis->update($this->redisPrefix, $WordsGroupsService);
        return Messages::Success();
    }

    public function deleteByID(Request $request, $id)
    {
        $WordsGroupsService = new WordsGroupsService();
        $WordsGroupsService->deleteByID($id);
        $this->redis->update($this->redisPrefix, $WordsGroupsService);
        return Messages::Deletion();
    }
}
