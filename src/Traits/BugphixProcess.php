<?php

namespace Bugphix\BugphixLaravel\Traits;

use Exception;
use Carbon\Carbon;
use Log;

// models
use Bugphix\BugphixLaravel\Models\Server;
use Bugphix\BugphixLaravel\Models\Client;
use Bugphix\BugphixLaravel\Models\User;
use Bugphix\BugphixLaravel\Models\Issue;
use Bugphix\BugphixLaravel\Models\StackTrace;
use Bugphix\BugphixLaravel\Models\Event;
use Bugphix\BugphixLaravel\Models\EventClient;
use Bugphix\BugphixLaravel\Models\EventServer;
use Bugphix\BugphixLaravel\Models\EventUser;

trait BugphixProcess
{
    use BugphixSetter;

    /**
     * This is where the saving of records happen.
     * Collecting all data and store it in database
     */
    protected function bugphixStore()
    {
        // $this->logBugphixVars();

        // STORE ISSUE
        $issue = Issue::firstOrCreate([
            'issue_project_id' => $this->bugphixProject->project_id,
            'issue_error_exception' => $this->bugphixIssue['error_exception'],
            'issue_error_message' => $this->bugphixIssue['error_message'],
        ]);
        $issue->issue_status = 'unresolved';
        $issue->updated_at = Carbon::now();
        $issue->save();

        // STORE EVENT
        $event = Event::create([
            'event_issue_id' => $issue->id,
            'event_environment' => $this->bugphixEvent['environment'],
        ]);

        // STORE STACKTRACE
        if (isset($event->id) && count($this->bugphixStackTrace)) {
            StackTrace::firstOrCreate([
                'stack_trace_event_id' => $event->id,
                'stack_trace_error_file' => $this->bugphixStackTrace['error_file'],
                'stack_trace_error_line' => $this->bugphixStackTrace['error_line'],
                'stack_trace_full_log' => $this->bugphixStackTrace['full_log'] ?? $this->bugphixException ?? '',
                'stack_trace_data' => $this->bugphixStackTrace['data'],
                'stack_trace_start_line' => $this->bugphixStackTrace['start_line'],
            ]);
        }

        // STORE SERVER
        if (count($this->bugphixServer)) {
            $server = Server::firstOrCreate([
                'server_name' => $this->bugphixServer['name'],
                'server_os' => $this->bugphixServer['os'],
                'server_os_version' => $this->bugphixServer['os_version'],
                'server_runtime' => $this->bugphixServer['runtime'],
            ]);
        }

        if (count($this->bugphixClient)) {
            $client = Client::firstOrCreate([
                'client_method' => $this->bugphixClient['method'],
                'client_url' => $this->bugphixClient['url'],
                'client_browser' => $this->bugphixClient['browser'],
                'client_browser_version' => $this->bugphixClient['browser_version'],
                'client_os' => $this->bugphixClient['os'],
                'client_ip' => $this->bugphixClient['ip'],
                'client_header' => isset($this->bugphixClient['header']) && count($this->bugphixClient['header']) ? $this->bugphixClient['header'] : null,
            ]);
        }

        if (count($this->bugphixUser)) {

            $user = User::where('user_unique', $this->bugphixUser['unique'])->first();

            if($user){
                $user->user_meta = $this->bugphixUser['meta'];
                $user->save();
            }
            else{
                $user = User::create([
                    'user_unique' => $this->bugphixUser['unique'],
                    'user_meta' => $this->bugphixUser['meta'],
                ]);
            }
        }

        /**
         * Create event relationship ids
         */

        if ($event) {
            if (isset($client) && !empty($client)) {
                EventClient::firstOrCreate([
                    'event_id' => $event->id,
                    'client_id' => $client->id,
                ]);
            }

            if (isset($server) && !empty($server)) {
                EventServer::firstOrCreate([
                    'event_id' => $event->id,
                    'server_id' => $server->id,
                ]);
            }

            if (isset($user) && !empty($user)) {
                EventUser::firstOrCreate([
                    'event_id' => $event->id,
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
