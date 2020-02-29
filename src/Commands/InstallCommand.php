<?php

namespace Bugphix\BugphixLaravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

// models
use Bugphix\BugphixLaravel\Models\Project;

class InstallCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'bugphix:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Bugphix';

    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    protected function findComposer()
    {
        if (file_exists(getcwd() . '/composer.phar')) {
            return '"' . PHP_BINARY . '" ' . getcwd() . '/composer.phar';
        }

        return 'composer';
    }

    /**
     * Execute the console command.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     *
     * @return void
     */
    public function handle(Filesystem $filesystem)
    {

        $this->info('Installing buckle bug...');

        // publish Bugphix config files
        $this->call('vendor:publish', ['--tag' => 'bugphix-config', '--force' => true]);

        // migrate database
        $this->info('Migrating database table');
        $this->call('migrate', ['--force' => true]);

        // dump autoloaded files
        $this->info('Dumping the autoloaded files and reloading all new files');
        $composer = $this->findComposer();
        $process = new Process($composer . ' dump-autoload');
        $process->setTimeout(null);
        $process->setWorkingDirectory(base_path())->run();

        $this->info('Creating default group');
        $this->registerLocalProject();

        $this->call('bugphix:assets-symlink');
        $this->comment("Bugphix successfully installed!");
    }

    private function registerLocalProject()
    {

        if (Project::count()) return; // stop creating if there is a default group

        Project::createProject(['project_name' => env('APP_NAME', 'Bugphix')]);
    }
}
