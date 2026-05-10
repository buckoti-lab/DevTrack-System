<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    // Admin dashboard project listing
    public function index()
    {
        $projects = Quote::with('project')->get();
        return view('progress', compact('projects'));
    }

    // Load tasks for modal (AJAX)
    public function tasks($quoteId)
    {
        $tasks = Task::where('project_id', $quoteId)->get();
        return response()->json($tasks);
    }


    public function editTask(Request $request, $id)
    {

        // logger($request);
        $request->validate([
            'status' => 'required|in:todo,in_progress,done',
            'assigned_to' => 'nullable|string',
            'estimated_hours' => 'nullable|numeric',
            'description' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high'
        ]);
        
        //dd($request->all());
        $task = Task::findOrFail($id);
        
        $user = User::where('sdms_id', $request->assigned_to)->firstOrFail();
        if(!$user){
            return response()->json([
                "success"=>false,
                "message"=>"Failed to fetch user id"
                ],404);
        }
        $assigned_to_id = $user->id;
       
        $task->update([
            'assigned_to' => $assigned_to_id,
            'description' => $request->description,
            'estimated_hours' => $request->estimated_hours,
            'status'=> $request->status ?? $task->status,
            'priority' => $request->priority
        ]);

        return response()->json([
            'success' => true,
            "message" => "Task updated successfully!"
            ]);
    }



    public function viewTask($taskId)
    {
        $task = Task::where('id', $taskId)->first();
        $task->assigned_to = User::where("id",$task->assigned_to)->value("sdms_id");

        return response()->json($task);
    }
}
