<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Words;
use App\Services\RedisService;
use App\Services\WordsService;
use App\Exceptions\Custom\RecordNotFoundException;
use App\Exceptions\Custom\Responses\Messages;
use Illuminate\Support\Facades\Storage;

class WordsController extends Controller
{
    protected $redis;
    protected $redisPrefix = 'Words';

    public function __construct(RedisService $serv)
    {
        $this->redis = $serv;
    }

    public function find(Request $request, $id)
    {
        $WordsService = new WordsService();
        $result = $WordsService->find($id);
        if(!$result){
            throw new RecordNotFoundException();
        }
       
        return response()->json($result);
    }

    public function search(Request $request)
    {
        $ws_name = $request->query('ws_name');
        $WordsService = new WordsService();
        $result = $WordsService->findByName($ws_name);
        if($result){
            return Messages::Success();
        }else{
            return Messages::RecordNotFound();
        }
    }

    public function findAll()
    {
        return response()->json(
            $this->redis->cache(
                $this->redisPrefix, 
                __FUNCTION__,
                function () {
                    $WordsService = new WordsService();
                    return $WordsService->findAll();
                }
            )
        );
    }

    public function add(Words\WordsRequest $request)
    {
        $reqData = $request->validated();
        $WordsService = new WordsService();
        $WordsService->add($reqData);
        $this->redis->update($this->redisPrefix, $WordsService);
        return Messages::Success();
    }

    public function edit(Words\WordsRequest $request, $id)
    {        
        $reqData = $request->validated();
        $WordsService = new WordsService();
        $WordsService->edit($reqData, $id);
        $this->redis->update($this->redisPrefix, $WordsService);
        return Messages::Success();
    }

    public function editCommon(Words\WsCommonRequest $request, $id)
    {        
        $reqData = $request->validated();
        $WordsService = new WordsService();
        $WordsService->editCommon($reqData, $id);
        $this->redis->update($this->redisPrefix, $WordsService);
        return Messages::Success();
    }

    public function editImportant(Words\WsImportantRequest $request, $id)
    {
        $reqData = $request->validated();
        $WordsService = new WordsService();
        $WordsService->editImportant($reqData, $id);
        $this->redis->update($this->redisPrefix, $WordsService);
        return Messages::Success();
    }

    public function deleteByID(Request $request, $id)
    {
        $WordsService = new WordsService();
        $WordsService->deleteByID($id);
        $this->redis->update($this->redisPrefix, $WordsService);
        return Messages::Deletion();
    }

    public function upload(Request $request)
    {       
        $uploadedFile = $request->file('ws_file');
        $fileName = uniqid() . '_' . $uploadedFile->getClientOriginalName();
        $filePath = $uploadedFile->storeAs('uploads', $fileName, 'public');
        /*$fileToDelete = 'uploads/6562e26c35060_S__70443015.jpg';
        if (Storage::disk('public')->exists($fileToDelete)) {
            Storage::disk('public')->delete($fileToDelete);
           echo 'deleted';
        } else {
            echo 'file not found for deletion  ';
        }*/
        if(Storage::disk('public')->exists($filePath)){
            echo 'upload file is exist';
        }
        return Messages::Success();
    }

    public function uppyUpload(Request $request)
    { 
       
        $fileMeta = $request->file('file');
        $fileName = uniqid() . '_' . $fileMeta->getClientOriginalName();
        $filePath = $fileMeta->storeAs('uploads',  $fileName, 'public');

        return Messages::Success();
    }   
    
}
