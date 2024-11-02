<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Words;
use App\Services\RedisService;
use App\Services\WordsService;
use App\Exceptions\Custom\RecordNotFoundException;
use App\Exceptions\Custom\Responses\Messages;
use Illuminate\Support\Facades\Storage;
use App\Events\BroadcastUpdate;

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

    public function store(Words\WordsRequest $request)
    {
        $reqData = $request->validated();
        $WordsService = new WordsService();
        $WordsService->store($reqData);
        $this->redis->update($this->redisPrefix, $WordsService);
        event(new BroadcastUpdate(['message' => 'should be update']));
        return Messages::Success();
    }

    public function update(Words\WordsRequest $request, $id)
    {
        $reqData = $request->validated();
        $WordsService = new WordsService();
        $WordsService->update($reqData, $id);
        $this->redis->update($this->redisPrefix, $WordsService);
        return Messages::Success();
    }

    public function updateCommon(Words\WordsRequest $request, $id)
    { 
        $reqData = $request->validated();
        $WordsService = new WordsService();
        $WordsService->updateCommon($reqData, $id);
        $this->redis->update($this->redisPrefix, $WordsService);
        return Messages::Success();
    }

    public function updateImportant(Words\WordsRequest $request, $id)
    {
        $reqData = $request->validated();
        $WordsService = new WordsService();
        $WordsService->updateImportant($reqData, $id);
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

    /** 以下測試用，功能尚未完成 */
    public function upload(Request $request)
    {  
        try {
            $uploadedFile = $request->file('ws_file');
            $fileName = uniqid() . '_' . $uploadedFile->getClientOriginalName();
            $uploadedFile->storeAs('uploads', $fileName, 'public');
            return Messages::Success();
        } catch(\Exception $e){
            return Messages::ProcessingFailed();
        }
    }

    public function uppyUpload(Request $request)
    {
        try {
            $fileMeta = $request->file('file');
            $fileName = uniqid() . '_' . $fileMeta->getClientOriginalName();
            $fileMeta->storeAs('uploads',  $fileName, 'public');
            return Messages::Success();
        } catch(\Exception $e){
            return Messages::ProcessingFailed();
        }
    }

    public function findUploads()
    {
        $files = Storage::disk('public')->files('uploads');

        $fileData = array_map(function ($file) {
            $fileName = pathinfo($file, PATHINFO_BASENAME);
            $fileUrl = url(Storage::url($file));
    
            return [
                'file_name' => $fileName,
                'file_url' => $fileUrl,
            ];
        }, $files);

        return response()->json($fileData, 200);
    }

    public function deleteUpload(Request $request, $id)
    {
        $fileName = $id;
        $filePath = "uploads/{$fileName}";
        try {
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
                return Messages::Deletion();
            }
            return Messages::RecordNotFound();
        } catch (\Exception $e) {
            return Messages::RecordNotFound();
        }
    }
    
}
