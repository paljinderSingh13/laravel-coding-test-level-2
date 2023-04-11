<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Task;
use App\Models\Project;

class TaskController extends Controller
{
         /**
     * Display a User listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();
        return response()->json(['tasks' => $tasks], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'title' => 'required',
                'user_id' => 'required',
                'project_id' => 'required',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

       $project_user_exist = Project::find($request->project_id)->users;
        if($project_user_exist){
           $data =  $project_user_exist->where('id',$request->user_id);
           if($data->count() > 0){
               $task = Task::create($request->all());
               return response()->json(['message' => 'Successfully Assign Team Member for this Task'], 201);
            }else{
                return response()->json(['errors' => "Team member is not associate with this project. Restric to assign task."], 422);

           }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'task not found'], 404);
        }
        return response()->json(['task' => $task], 200);
    }
/**
     * Update the specified idempotent resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function idempotent_update(Request $request, $id)
        {
            $task = Task::findOrFail($id);
            $status_data = ['NOT_STARTED', 'IN_PROGRESS', 'READY_FOR_TEST', 'COMPLETED'];
            if(!in_array($request->input('status'),$status_data)){
                return response()->json(['error' => 'Status is not valid'], 404);
            }
            $task->title = $request->input('title');
            $task->description = $request->input('description');
            $task->status = $request->input('status');
            $task->save();

            return response()->json([
                'message' => 'task status updated successfully',
                'data' => $task
            ], 200);
        }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'task not found'], 404);
        }

        try {
            $this->validate($request, [
                'name' => 'required|unique:projects',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $task->update($request->all());
        return response()->json(['task' => $task], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'task not found'], 404);
        }
        $task->delete();
        return response()->json(['message' => 'Task delete successfully'], 200);
    }
}
