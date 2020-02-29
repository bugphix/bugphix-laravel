<?php

namespace Bugphix\BugphixLaravel\Http\Controllers;

use Illuminate\Http\Request;

// models
use Bugphix\BugphixLaravel\Models\User;

// resource controller
use Bugphix\BugphixLaravel\Http\Collections\UserCollection;
use Bugphix\BugphixLaravel\Http\Resources\UserResource;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (isset($_GET['sort']) && $_GET['sort'] === 'oldest') {
            $items = User::orderBy('id', 'desc');
        } else {
            $items = User::orderBy('id', 'asc');
        }

        $items->searchUser($_GET['keyword'] ?? '');
        $users = $items->paginate(10);
        $results = $users;
        $results->data = UserCollection::collection($users);

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

        $item = User::find($id);

        if ($item) {
            $success = true;
            $results = $item;
        }

        return response()->json([
            'success' => $success,
            'results' => new UserResource($results),
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
