<?php

namespace Bugphix\BugphixLaravel\Traits;

use Exception;
use Log;

// models
use Bugphix\BugphixLaravel\Models\Project;

trait BugphixSetter
{
    use BugphixClientDetails, BugphixHelpers;

    protected $bugphixException;
    protected $bugphixProject;
    protected $bugphixIssue = [];
    protected $bugphixEvent = [];
    protected $bugphixStackTrace = [];
    protected $bugphixServer = [];
    protected $bugphixClient = [];
    protected $bugphixUser = [];

    /**
     * Setup project
     */

    protected function setProject(string $projectId = '')
    {
        $this->bugphixProject = '';
        try {
            $this->bugphixProject = Project::projectId($projectId)->isActive()->first();
            if (!$projectId && !$this->bugphixProject) {
                // get the default project
                $this->bugphixProject = Project::isActive()->first();
            }
        } catch (Exception $e) {
        }
    }

    /**
     * Create issue
     */

    protected function setIssue(array $issue=[])
    {
        if(count($issue)){
            $this->bugphixIssue = $issue;
            return;
        }

        try {
            $e = (object) $this->getExceptionInArray();
            $this->bugphixIssue = array(
                'project_id' => $this->bugphixProject->project_id,
                'error_exception' => $e->exception ?? 'Unknown Error',
                'error_message' => $e->message ?? 'Error',
            );
        } catch (Exception $e) {
        }
    }

    /**
     * Create event
     */

    protected function setEvent(array $event=[])
    {
        if(count($event)){
            $this->bugphixEvent = $event;
            return;
        }

        try {
            $this->bugphixEvent = array(
                'environment' => app()->environment() ?? 'local',
            );
        } catch (Exception $e) {
        }
    }

    /**
     * Generate custom stack trace
     */

    protected function setStackTrace(array $stackTrace = [])
    {
        if(count($stackTrace)){

            if(!isset($stackTrace['full_log']) && $this->bugphixException){
                if(is_array($this->bugphixException)){
                    $stackTrace['full_log'] = implode(PHP_EOL, $this->bugphixException);
                }
                else{
                    $stackTrace['full_log'] = $this->bugphixException;
                }
            }

            $this->bugphixStackTrace = $stackTrace;
            return;
        }

        try {
            $getStackTrace = (object) $this->generateStackTrace();
            $e = (object) $this->getExceptionInArray();
            $this->bugphixStackTrace = array(
                'error_file' => $e->file ?? 'Unknown file',
                'error_line' => $e->line ?? 0,
                'full_log' => $this->bugphixException,
                'data' => $getStackTrace->data ?? [],
                'start_line' => $getStackTrace->start_line ?? 1,
            );
        } catch (Exception $e) {
        }
    }

    /**
     * Automatically generate details for current server
     */

    protected function setServer(array $server=[])
    {
        if(count($server)){
            $this->bugphixServer = $server;
            return;
        }

        try {
            $this->bugphixServer = array(
                'name' => php_uname('n'), // Host name
                'os' => php_uname('s'), // Operating system
                'os_version' => php_uname('v'), // version name
                'runtime' => 'PHP v' . phpversion(),
            );
        } catch (Exception $e) {
        }
    }

    /**
     * Automatically capture client's information
     */

    protected function setClient(array $client=[])
    {
        if(count($client)){
            $this->bugphixClient = $client;
            return;
        }

        if (!$this->getBrowser() && !$this->getPlatform()) return;

        try {
            $this->bugphixClient = array(
                'method' => $_SERVER['REQUEST_METHOD'] ?? 'Unknown Method',
                'url' => $this->getEventUrl(),
                'browser' => $this->getBrowser(),
                'browser_version' => $this->getVersion(),
                'os' => $this->getPlatform(),
                'ip' => $this->getClientIp(),
                'header' => $this->getHeaders() ?? [],
            );
        } catch (Exception $e) {
        }
    }

    /**
     * Set user details
     */

    protected function setUser($userUnique, array $userMeta)
    {

        try {
            $this->bugphixUser = array(
                'unique' => $userUnique,
                'meta' => $userMeta,
            );
        } catch (Exception $e) {
        }
    }
}
