<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class DocumentController extends Controller
{
    public function index()
    {
        $data = Document::all();
    
        return $this->sendResponse($data, 'Success get Document');
    }
    public function create(Request $request)
    {
        try{
            $valid_arr = [
	            "title" => "required",
	            "content" => "required",
	            "signing" => "required|mimes:jpg,jpeg,png",
            ];
            $valid = Validator::make($request->all(), $valid_arr);
            if ($valid->fails()){
                return $this->sendError('Invalid Validation', $valid->errors(), 400);
            }
	        if ($request->hasFile("signing")){
	            $signing = $request->file("signing");
	        	if($signing->getSize() > 100000)
                    return $this->sendError('Invalid Validation', ["signing" => ["Max file size 100 KB. Uploaded image size ".($signing->getSize() / 1000)." KB"]], 400);
	        	$filename = date("YmdHis").".".$signing->extension();
	            \Storage::putFileAs("public/images/document", $signing, $filename);
	            $filename = "storage/images/document/".$filename;
	        }
	        else{
                return $this->sendError('Invalid Validation', ["signing" => ["Signing file is empty"]], 400);
	        }
            
            // dd($request->title);
            $document = Document::create([
	            "title" => $request->title,
	            "content" => $request->content,
	            "signing" => $filename,
            ]);
            return $this->sendResponse($document, 'Document created');
        } catch(Exception $error){
            Log::channel("daily")->info("Document.create() catch");
            Log::channel("daily")->info($error);
            return $this->sendError('Document Created', [
                'message' => 'something when wrong',
                'error' => $error
            ]);
        }
    }
    public function update(Request $request, $id)
    {
        try{
            $valid_arr = [
	            "date" => "required|date_format:Y-m-d|unique:App\Models\Document,date,{$id},id",
                "type" => "required|in:IOH,Public",
            ];
            $valid = Validator::make($request->all(), $valid_arr);
            if ($valid->fails()){
                return $this->sendError('Invalid Validation', $valid->errors(), 400);
            }
            $document = Document::find($id);
            if($document == null){
                return $this->sendError('Invalid Validation', ["id" => ["Document not found"]], 400);
            }
            
            // dd($request->title);
            $document->update([
	            "date" => $request->date,
	            "type" => $request->type,
            ]);
            return $this->sendResponse($document, 'Document updated');
        } catch(Exception $error){
            Log::channel("daily")->info("Document.update() catch");
            Log::channel("daily")->info($error);
            return $this->sendError('Document Updated', [
                'message' => 'something when wrong',
                'error' => $error
            ]);
        }
    }
    public function delete($id)
    {
        try{
            $document = Document::find($id);
            if($document == null){
                return $this->sendError('Invalid Validation', ["id" => ["Document not found"]], 400);
            }
            $document->delete();
            return $this->sendResponse($document, 'Document deleted');
        } catch(Exception $error){
            Log::channel("daily")->info("Document.delete() catch");
            Log::channel("daily")->info($error);
            return $this->sendError('Document Deleted', [
                'message' => 'something when wrong',
                'error' => $error
            ]);
        }
    }
}
