<?php

namespace Bugphix\BugphixLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Bugphix\BugphixLaravel\Models\Event;

//resource controller
use Bugphix\BugphixLaravel\Http\Resources\EventResource;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $results = Event::projectId($_GET['project_id'] ?? 'default')->latest()->paginate(10);

        // return response()->json([
        //     'success' => true,
        //     'results' => $results,
        // ]);
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

        $item = Event::find($id);

        if ($item) {
            $success = true;
            $results = $item;
        }

        return response()->json([
            'success' => $success,
            'results' => new EventResource($results),
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
        //
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
