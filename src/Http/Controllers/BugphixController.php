<?php

namespace Bugphix\BugphixLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Log;

// models
use Bugphix\BugphixLaravel\Models\Project;

class BugphixController extends Controller
{
    public function home()
    {
        return redirect(url(config('bugphix.dashboard.url') . '/issues'));
    }

    public function main()
    {
        return view('bugphix::main');
    }

    public function getActiveProject($projectId = '')
    {
        $success = false;
        $results = [];

        if ($projectId) {
            $results = Project::projectId($projectId)->first();
        } else {
            $results = Project::first();
        }

        if ($results) $success = true;

        return response()->json([
            'success' => $success,
            'results' => $results,
        ]);
    }

    public function getProjectListOptions()
    {
        $success = false;
        $results = Project::withTrashed()->get();
        if ($results) $success = true;

        return response()->json([
            'success' => $success,
            'results' => $results,
        ]);
    }
}
