<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    //
    public function index($id){
        $project = Project::findOrFail($id);
        return response()->json($project);
    }

   public function edit($id,$status){
        logger($id.$status);
        $project = Project::findOrFail($id);
        $project->update([
            "status" => $status
        ]);
        return response()->json([
            "success" => true,
            "message" => "Project status updated successfully"
        ]);
    }
}
