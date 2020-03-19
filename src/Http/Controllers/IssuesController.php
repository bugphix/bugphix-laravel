<?php

namespace Bugphix\BugphixLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Bugphix\BugphixLaravel\Models\Issue;

// resource controller
use Bugphix\BugphixLaravel\Http\Collections\IssueCollection;
use Bugphix\BugphixLaravel\Http\Resources\IssueResource;

class IssuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (isset($_GET['sort']) && $_GET['sort'] === 'oldest') {
            $items = Issue::oldest('updated_at');
        } else {
            $items = Issue::latest('updated_at');
        }
        $items->projectId($_GET['project_id'] ?? 'default');
        $items->status(strtolower($_GET['status'] ?? 'unresolved'));

        $items->searchIssue($_GET['keyword'] ?? '');

        $results = $items->paginate(10);
        $results->data = IssueCollection::collection($results);

        return response()->json([
            'success' => true,
            'results' => $results
        ]);

        // return new IssueResource($results);
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

        $item = Issue::projectId($_GET['project_id'] ?? 'default')->find($id);

        if ($item) {
            $success = true;
            $results = $item;
        }

        return response()->json([
            'success' => $success,
            'results' => new IssueResource($results),
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
    public function update(Request $req, $id)
    {
        $success = false;
        $message = 'Updating issue failed';

        $item = Issue::find($id);

        $post = $req->all();

        if ($item && count($post)) {

            unset($post['id']);
            unset($post['issue_project_id']);

            $item->update($post);
            $success = true;
            $message = 'Issue updated!';
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
        $success = false;
        $message = 'Cannot delete issue';

        $delete = Issue::where('id', $id)->delete();
        if ($delete) {
            $success = true;
            $message = 'Issue deleted!';
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function bulkUpdate(Request $req, $id)
    {
        $ids = explode(',', $id);
        $success = false;
        $message = 'Updating issue failed';

        if (count($ids)) {
            $item = Issue::whereIn('id', $ids);
            $post = $req->all();
            if ($item && count($post)) {
                unset($post['id']);
                unset($post['issue_project_id']);

                $item->update($post);
                $success = true;
                $message = count($ids) .' Issues updated!';
            }
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function bulkDelete($id)
    {
        $ids = explode(',', $id);
        $success = false;
        $message = 'Deleting issue failed';

        if (count($ids)) {
            $delete = Issue::whereIn('id', $ids)->delete();
            if ($delete) {
                $success = true;
                $message = count($ids) .' Issues deleted!';
            }
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
