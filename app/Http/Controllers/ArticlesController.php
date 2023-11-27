<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Articles\ArticlesRequest;
use App\Services\RedisService;
use App\Services\ArticlesService;
use App\Exceptions\Custom\RecordNotFoundException;
use App\Exceptions\Custom\Responses\Messages;

class ArticlesController extends Controller
{
    protected $redis;
    protected $redisPrefix = 'Articles';

    public function __construct(RedisService $serv)
    {
        $this->redis = $serv;
    }

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
        return response()->json(
            $this->redis->cache(
                $this->redisPrefix, 
                __FUNCTION__,
                function () {
                    $ArticlesService= new ArticlesService();
                    return $ArticlesService->findAll();
                }
            )
        );
    }

    public function add(ArticlesRequest $request)
    {
        $reqData = $request->validated();
        $ArticlesService = new ArticlesService();
        $ArticlesService->add($reqData);
        $this->redis->update($this->redisPrefix, $ArticlesService);
        return Messages::Success();
    }

    public function edit(ArticlesRequest $request, $id)
    {
        $reqData = $request->validated();
        $ArticlesService = new ArticlesService();
        $ArticlesService->edit($reqData, $id);
        $this->redis->update($this->redisPrefix, $ArticlesService);
        return Messages::Success();
    }

    public function deleteByID(Request $request, $id)
    {
        $ArticlesService = new ArticlesService();
        $ArticlesService->deleteByID($id);
        $this->redis->update($this->redisPrefix, $ArticlesService);
        return Messages::Deletion();
    }
}
