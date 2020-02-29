<?php

namespace Bugphix\BugphixLaravel\Http\Controllers;

use Illuminate\Http\Request;
use Log;

// models
use Bugphix\BugphixLaravel\Models\Project;

// traits
use Bugphix\BugphixLaravel\Traits\BugphixProcess;

class DSNController extends Controller
{
    use BugphixProcess;

    public function store(Request $req, $projectId, $token)
    {
        $code = 422;
        $response = array(
            'success' => false,
            'message' => 'Unprocessable Entity',
        );

        $project = Project::isActive()->projectId($projectId)->first();

        if (!$project) {
            $response['message'] = 'Project not found';
        } else {
            if ($project->project_token !== $token) {
                $code = 401;
                $response['message'] = "Invalid token";
            } else {
                $code = 200;

                // 'exception' => $this->bugphixException,
                // 'issue' => $this->bugphixIssue,
                // 'stack_trace' => $this->bugphixStackTrace,
                // 'server' => $this->bugphixServer,
                // 'client' => $this->bugphixClient,
                // 'user' => $this->bugphixUser,

                // Log::info($req->exception);
                // Log::debug($req->issue);
                // Log::info(json_encode($req->stack_trace));
                // Log::debug($req->server);
                // Log::debug($req->client);
                // Log::debug($req->user);

                // Log::info($req->exception);
                // Log::debug($req->all());

                $req->validate([
                    'bphix_exception' => 'required',
                    'bphix_issue' => 'required',
                    'bphix_event' => 'required',
                    'bphix_stack_trace' => 'required',
                ]);

                if ($req->all()) {
                    if (is_array($req->exception)) {
                        $e = implode(PHP_EOL, $req->bphix_exception);
                    } else {
                        $e = $req->bphix_exception;
                    }

                    $this->bugphixException = $e;
                    $this->setProject($project->project_id);
                    $this->setIssue($req->bphix_issue);
                    $this->setEvent($req->bphix_event);
                    $this->setStackTrace($req->bphix_stack_trace);

                    if($req->has('bphix_server')){
                        $this->setServer($req->bphix_server);
                    }
                    if($req->has('bphix_client')){
                        $this->setClient($req->bphix_client);
                    }
                    if(isset($req->bphix_user['unique'])){
                        $this->setUser($req->bphix_user['unique'], $req->bphix_user['meta'] ?? []);
                    }
                    $this->bugphixStore();

                    // Log::info(PHP_EOL.PHP_EOL.'----------------- dsn -----------------');
                    // Log::info($this->bugphixException);
                    // Log::debug($this->bugphixProject);
                    // Log::debug($this->bugphixIssue);
                    // Log::debug($this->bugphixEvent);
                    // Log::info(json_encode($this->bugphixStackTrace));
                    // Log::debug($this->bugphixServer);
                    // Log::debug($this->bugphixClient);
                    // Log::debug($this->bugphixUser);

                    // Log::info('----------------- dsn END -----------------'.PHP_EOL.PHP_EOL);


                    $response['success'] = true;
                    unset($response['message']);
                }
            }
        }

        return response()->json($response, $code);
    }
}
