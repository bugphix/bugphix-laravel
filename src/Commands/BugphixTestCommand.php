<?php

namespace Bugphix\BugphixLaravel\Commands;

use Illuminate\Console\Command;
use Exception;

class BugphixTestCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'bugphix:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate test event for bugphix error';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {

        $errorReporting = error_reporting(E_ALL | E_STRICT);

        try {
            $this->info('Creating bugphix event');
            $app = app('bugphix');
            $exception = $this->generateException('test bugphix', ['bug' => 'phix']);

            $userUnique = 'ID:'. rand(100,1000);
            $userMeta = array(
                'ID' => $userUnique,
                'email' => 'test-user@bugphix.com',
                'name' => 'Bugphix user'
            );

            $app->configUser($userUnique, $userMeta)->catchError($exception);

            $this->comment('Test error created');

        } catch (Exception $e) {
            $this->error("Generating bugphix test event {$e->getMessage()}");
        }

        error_reporting($errorReporting);
    }

    /**
     * Generate a test exception to send to Sentry.
     *
     * @param $command
     * @param $arg
     *
     * @return \Exception
     */
    protected function generateException($command, $arg): ?Exception
    {
        try {
            throw new Exception('This is a test exception sent from the command [bugphix:test]');
        } catch (Exception $ex) {
            return $ex;
        }
    }
}
