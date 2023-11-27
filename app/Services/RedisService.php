<?php
namespace App\Services;

use Illuminate\Support\Facades\Redis;

class RedisService
{
    public function cache($prefix, $funName, $callback, $expiration = 600)
    {
        $redisKey = $prefix . ':' . $funName;
        $cacheResult = Redis::get($redisKey);

        if ($cacheResult) {
            return json_decode($cacheResult, true);
        }

        $result = $callback();

        Redis::setex($redisKey, $expiration, json_encode($result));

        return $result;
    }

    public function update($prefix, $Service, $expiration = 600)
    {        
        switch ($prefix) {
            case 'Words':
            case 'Articles': 
            case 'TagsColor': 
            case 'WordsGroups':
                $result = $Service->findAll();
                $redisKey = $prefix. ':findAll';
                Redis::setex($redisKey, $expiration, json_encode($result));
                break;
            case 'Categories':
            case 'Tags':
                $result = $Service->findAll();
                $redisKey = $prefix. ':findAll';
                Redis::setex($redisKey, $expiration, json_encode($result));
                $result = $Service->findRecent();
                $redisKey = $prefix. ':findRecent';
                Redis::setex($redisKey, $expiration, json_encode($result));
                break;
            default:
                break;
        }
    }
}