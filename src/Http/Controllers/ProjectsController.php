<?php

namespace Bugphix\BugphixLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Bugphix\BugphixLaravel\Models\Project;

// resource controller
use Bugphix\BugphixLaravel\Http\Collections\ProjectCollection;
use Bugphix\BugphixLaravel\Http\Resources\ProjectResource;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (isset($_GET['sort']) && $_GET['sort'] === 'oldest') {
            $items = Project::oldest();
        } else {
            $items = Project::latest();
        }

        $items->searchProject($_GET['keyword'] ?? '');

        $projects = $items->paginate(10);
        $results = $projects;
        $results->data = ProjectCollection::collection($projects);

        return response()->json([
            'success' => true,
            'results' => $results
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $project = Project::createProject(['project_name' => $request->project_name]);

        return response()->json([
            'success' => true,
            'results' => new ProjectResource($project)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $success = false;
        $results = [];

        $item = Project::where('project_id', $id)->first();

        if ($item) {
            $success = true;
            $results = $item;
        }

        return response()->json([
            'success' => $success,
            'results' => new ProjectResource($results),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $success = false;
        $message = 'Updating project failed';

        $item = Project::where('project_id', $id)->first();

        if ($item) {
            $item->project_name = $request->project_name;
            $item->is_active = $request->is_active;
            $item->save();
            $success = true;
            $message = 'Project updated!';
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
