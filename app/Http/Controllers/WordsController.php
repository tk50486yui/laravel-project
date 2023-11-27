<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\Words;
use App\Services\WordsService;
use App\Exceptions\Custom\RecordNotFoundException;
use App\Exceptions\Custom\Responses\Messages;
use Illuminate\Support\Facades\Storage;

class WordsController extends Controller
{
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
        $WordsService = new WordsService();
        $result = $WordsService->findAll();
       
        return response()->json($result);
    }

    public function add(Words\WordsRequest $request)
    {        
        $reqData = $request->validated();
        $WordsService = new WordsService();
        $WordsService->add($reqData);
        return Messages::Success();
    }

    public function edit(Words\WordsRequest $request, $id)
    {        
        $reqData = $request->validated();
        $WordsService = new WordsService();
        $WordsService->edit($reqData, $id);
        return Messages::Success();
    }

    public function editCommon(Words\WsCommonRequest $request, $id)
    {        
        $reqData = $request->validated();
        $WordsService = new WordsService();
        $WordsService->editCommon($reqData, $id);
        return Messages::Success();
    }

    public function editImportant(Words\WsImportantRequest $request, $id)
    {
        $reqData = $request->validated();
        $WordsService = new WordsService();
        $WordsService->editImportant($reqData, $id);
        return Messages::Success();
    }

    public function deleteByID(Request $request, $id)
    {
        $WordsService = new WordsService();
        $WordsService->deleteByID($id);
        return Messages::Success();
    }

    public function upload(Request $request)
    { 
        echo $request;
        $uploadedFile = $request->file('ws_file');
        //echo $request['ws_name'];
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
            echo $filePath;
            echo '  upload file is exist';
        }
        return Messages::Success();
    }

    public function uppyUpload(Request $request)
    { 
   
        $client = new \TusPhp\Tus\Client('http://localhost/git/laravel-vocabulary/public/api/words/server/tus');
       
        $fileMeta = $request->file('file');     
        //echo $_FILES['ws_file']['name'];
       // echo $_FILES["file"];
        $fileName = uniqid() . '_' . $fileMeta->getClientOriginalName();
       // $uploadKey = hash_file('md5', $fileMeta);     
        $filePath = $fileMeta->storeAs('uploads',  $fileName, 'public');
       
    }
    
}
