<?php

namespace Bugphix\BugphixLaravel;

use GuzzleHttp\Client as GuzzleClient;
use Exception;
use Log;

//traits
use Bugphix\BugphixLaravel\Traits\BugphixProcess;
use Bugphix\BugphixLaravel\Traits\BugphixHelpers;

class Bugphix
{
    use BugphixProcess, BugphixHelpers;

    public function version()
    {
        return 'v1.5';
    }

    public function asset($asset = '')
    {
        return trim(url(config('bugphix.assets.url')) . "{$asset}", '/');
    }

    public function isAssetsExists()
    {
        try {
            $fileHeaders = get_headers($this->asset('/js/app.js'));
            return stripos($fileHeaders[0], "200 OK") ? true : false;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function catchError(Exception $e)
    {
        // $timeStart = microtime(true);
        $this->setProject();

        if (!$this->bugphixProject) return;

        $this->bugphixException = $e;
        $this->setIssue();
        $this->setEvent();
        $this->setStackTrace();
        $this->setServer();
        $this->setClient();

        if (!$this->hasActiveDSN()) {
            $this->bugphixStore();
        } else {
            // pass to active dsn instead
            try {
                $dsn = config('bugphix.dsn');
                $client = new GuzzleClient(); //GuzzleHttp\Client
                $res = $client->request('POST', $dsn, [
                    'form_params' => [
                        'bphix_exception' => explode(PHP_EOL, $this->bugphixException),
                        'bphix_issue' => $this->bugphixIssue,
                        'bphix_event' => $this->bugphixEvent,
                        'bphix_stack_trace' => $this->bugphixStackTrace,
                        'bphix_server' => $this->bugphixServer,
                        'bphix_client' => $this->bugphixClient,
                        'bphix_user' => $this->bugphixUser,
                    ]
                ]);

                Log::info($res->getBody());
            } catch (Exception $e) {
                dd($e);
            }
        }
        // Log::info('EXEC TIME: ' . number_format(microtime(true) - $timeStart, 2) . PHP_EOL . PHP_EOL);
    }

    public function configUser($userUnique = '', array $userMeta = [])
    {
        if (!$userUnique || !is_array($userMeta)) return $this;
        $this->setUser($userUnique, $userMeta);
        return $this;
    }
}
