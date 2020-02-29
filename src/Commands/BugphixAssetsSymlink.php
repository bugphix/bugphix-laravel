<?php

namespace Bugphix\BugphixLaravel\Commands;

use Illuminate\Console\Command;

class BugphixAssetsSymlink extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'bugphix:assets-symlink';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create bugphix assets symlink';

    /**
     * Execute the console command.
     *
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     *
     * @return void
     */
    public function handle()
    {
        if (file_exists(public_path('bugphix-assets'))) {
            $this->comment("Symlink already exists!");
            return;
        }
        \App::make('files')->link(__DIR__ . '/../../assets/', public_path('bugphix-assets'));
        $this->comment("Symlink created!");
    }
}
