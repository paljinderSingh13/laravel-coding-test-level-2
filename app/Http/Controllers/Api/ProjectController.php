<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Project;

class ProjectController extends Controller
{
     /**
     * Display a User listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return response()->json(['projects' => $projects], 200);
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
                'name' => 'required|unique:projects',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
        $project = Project::create($request->all());
        return response()->json(['Project' => $project], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['error' => 'Project not found'], 404);
        }
        return response()->json(['Project' => $project], 200);
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
            $project = Project::findOrFail($id);

            $project->name = $request->input('name');
            $project->save();

            return response()->json([
                'message' => 'Project updated successfully',
                'data' => $project
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
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['error' => 'Project not found'], 404);
        }

        try {
            $this->validate($request, [
                'name' => 'required|unique:projects',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }

        $project->update($request->all());
        return response()->json(['Project' => $project], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['error' => 'Project not found'], 404);
        }
        $project->delete();
        return response()->json(['message' => 'Project delete successfully'], 204);
    }
     /**
     * Assign the specified resource to Project.
     *
      * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assign_user(Request $request){
        $project = Project::find($request->project_id);
        if(Project::find($request->project_id)->users->count()>0){
            return response()->json(['error' => 'Team Member already associate to project'], 404);
        }
        $project->users()->attach($request->user_ids);
        $project->save();
        return response()->json([
            'message' => 'Assign user to project  successfully',
        ], 201);
    }
    /**
     * projects pagnation  search sort sortBy sortDirection  the specified  to Project.
     *
      * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function projects(Request $request){
        $query = Project::query();
        if(!empty($request['search'])){
            $query->where('name', 'LIKE', '%'.$request['search'].'%');
        }
        $page = $request['pageIndex'] ?? 0;
        $pageSize = $request['pageSize'] ?? 3;
        $sortBy = $request['sortBy'] ?? 'name';
        $sortDirection = $request['sortDirection'] ?? 'asc';
        $data = $query->orderBy($sortBy, $sortDirection)->paginate($pageSize, ['*'], 'pageIndex', $page);
        return response()->json(['data' => $data], 200);
    }
}
