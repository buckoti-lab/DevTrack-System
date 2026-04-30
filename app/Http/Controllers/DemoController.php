<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Demo;
use Illuminate\Support\Facades\Storage;

class DemoController extends Controller
{
    //
    public function index($id){
        
       $project_demo = Demo::where("project_id",$id)->get();

       return response()->json($project_demo);
    }

    public function validateFile($request){
      if($request->hasFile("file")){
          $file = $request->file('file');
          $file_extension = $file->getClientOriginalExtension();
          if($file_extension === "mp4"){
            $type = "video";
            $file_path =  public_path("storage/uploads/videos/demo");
          }else{
            $type = "image";
            $file_path =  public_path("storage/uploads/images/demo");
          }
          $filename = $type .'_'.time() . '.' . $file_extension;
          $file->move($file_path, $filename);

          $filename_filetype = Array("filename"=>$filename,"type"=>$type); 
          
          return $filename_filetype;
       }
    }

    public function store(Request $request){

        $uploaded_by = Auth::user();

        $request->validate([
             "description"=>'required',
             "file"=>'required|file|mimes:mp4,jpeg,jpg,png|max:10240',
             "demo_project_id"=>"required"
        ]);

        $filename_filetype = $this->validateFile($request);

        $demo = Demo::create([
            "description"=>$request->description,
            "filename"=>$filename_filetype["filename"],
            "uploaded_by"=>$uploaded_by->id,
            "type"=>$filename_filetype["type"],
            "project_id"=>$request->demo_project_id
        ]);

        if($demo){
            return response()->json([
                "success"=>true,
                "message"=>"Demo file added successfully!"
            ]);
        }
    }
    
    public function edit(Request $request){
        
        $current_user = Auth::user();

        // dd("Description:".$request->description);

        $request->validate([
             "description"=>'required',
             "file"=>'required|file|mimes:mp4,jpeg,jpg,png|max:10240',
             "demoId"=>"required"
        ]);

        $filename_filetype = $this->validateFile($request);

        $demo = Demo::findOrfail($request->demoId);

        $update_demo = $demo->update([
            "description"=>$request->description,
            "updated_by"=>$current_user->id,
            "filename"=>$filename_filetype["filename"],
            "type"=>$filename_filetype["type"]
        ]);

        if($update_demo){
            return response()->json([
                "success"=>true,
                "message"=>"Demo content updated successfully!"
            ]);
        }
    }


    public function delete($id){
        $delete_demo = Demo::destroy($id);
        if($delete_demo){
            return response()->json([
                "success"=>true,
                "message"=>"Demo deleted successfully!"
            ]);
        }
    }

    public function view($id){
        $file = Demo::findOrfail($id);
        $filename = $file->filename;
        $filetype = $file->type;
        if($file && ($filetype === "video")){
            $file_path =  "storage/uploads/videos/demo/".$filename;
        }else{
            $file_path = "storage/uploads/images/demo/".$filename;
        }
        
        $file['file_path'] = $file_path;
        
        return response()->json([
            "success"=>true,
            "file"=>$file
        ]);
    }
}
