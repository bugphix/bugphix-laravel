<?php

namespace Bugphix\BugphixLaravel\Traits;

use Exception;
use Log;

trait BugphixHelpers
{
    protected function getEventUrl()
    {
        if (isset($_SERVER['HTTP_HOST'])) {
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'  ? "https" : "http";
            return "{$protocol}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
        }
        return '';
    }

    protected function getExceptionInArray()
    {
        return [
            'message' => $this->bugphixException->getMessage(),
            'exception' => get_class($this->bugphixException),
            'file' => $this->bugphixException->getFile(),
            'line' => $this->bugphixException->getLine()
        ];
    }

    protected function generateStackTrace()
    {
        $e = (object) $this->getExceptionInArray();

        if (!file_exists($e->file)) return [];

        $readFile = explode("\n", file_get_contents($e->file));

        if (!is_array($readFile)) return [];
        if (count($readFile) === 0) return [];

        $buffLine = 15;
        $startLine = ($e->line - 1) - $buffLine;
        $endLine = ($buffLine * 2) + 1;

        // check file line limitations
        $startLine = $startLine <= 0 ? 0 : $startLine;

        return [
            'data' => array_slice($readFile, $startLine, $endLine),
            'start_line' => $startLine + 1, // remove 0 index
        ];
    }

    protected function getHeaders()
    {
        if (function_exists('getallheaders')) return getallheaders();
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }

    protected function hasActiveDSN()
    {
        return config('bugphix.dsn') !== '' && filter_var(config('bugphix.dsn'), FILTER_VALIDATE_URL);
    }

    protected function logBugphixVars()
    {
        Log::info(PHP_EOL.PHP_EOL.'----------------- dsn -----------------');
        Log::info($this->bugphixException);
        Log::debug($this->bugphixProject);
        Log::debug($this->bugphixIssue);
        Log::debug($this->bugphixEvent);
        Log::info(json_encode($this->bugphixStackTrace));
        Log::debug($this->bugphixServer);
        Log::debug($this->bugphixClient);
        Log::debug($this->bugphixUser);
        Log::info('----------------- dsn END -----------------'.PHP_EOL.PHP_EOL);
    }
}
