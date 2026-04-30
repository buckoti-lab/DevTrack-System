<?php

namespace App\Http\Controllers;

use App\Models\Document;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use PDF;

class DocumentController extends Controller
{
    //
    public function index(){
        // return view('documents');
        $documents = Document::all();
        return view('documents',compact('documents'));
    }

    public function validateFile($request){
      if($request->hasFile("file")){
          $file = $request->file('file');
          $filename = time() . $request->type . '.' . $file->getClientOriginalExtension();
          $file->move(public_path('storage/uploads/documents'), $filename);
          
          return $filename;
       }
    }

    public function store(Request $request){

       $user = Auth::user();
       
       $request->validate([
         "name"=>'required',
         "type"=>'required',
         "file"=>'required|file|mimes:pdf,docx|max:2048',
         "description"=>'nullable',
       ]);

       $filename = $this->validateFile($request);

       $document = Document::create([
         "name"=>$request->name,
         "type"=>$request->type,
         "description"=>$request->description,
         "uploaded_by"=>$user->id,
         "filename"=>$filename
       ]);

       if($document){
         return json_encode([
          "success"=>true,
          "message"=>"Document uploaded successfully!"
         ]);
       }
       
    }

    public function update(Request $request, $id){

      $current_user = Auth::user();

      $document = Document::findOrFail($id);

      $request->validate([
          "name"=>'required',
          "type"=>'required',
          "file"=>'required|file|mimes:pdf,docx|max:2048',
          "description"=>'nullable',
      ]);

      $filename = $this->validateFile($request);

      $update_document = $document->update([
          "name"=>$request->name,
          "type"=>$request->type,
          "description"=>$request->description,
          "updated_by"=>$current_user->id,
          "filename"=>$filename
      ]);

      if($update_document){
        return json_encode([
          "success"=>true,
          "message"=>"Document updated successfully!"
        ]);
      }
    }

    public function delete($id){
       $delete_document = Document::destroy($id);

       if($delete_document){
         return json_encode([
          "success"=>true,
          "message"=>"Document deleted successfully!"
         ]);
       }
    }

    public function download($id){
      $document = Document::findOrFail($id);
      $document_name = $document->filename;
      $document_path = "storage/uploads/documents/".$document_name;
      
      return $document_path;

    }

    public function view($id){
      $document = Document::findOrFail($id);
      $document_name = $document->filename;
      $document_path = asset("storage/uploads/documents/" . $document_name);

      return response()->json([
        "success"=>true,
        "file"=>$document_path
      ]);
/*     $mime_type = mime_content_type($document_path );
    return response()->file($document_path , [
        'Content-Type' => $mime_type,
    ]); */

    }
}
