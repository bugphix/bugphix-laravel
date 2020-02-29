<?php

namespace Bugphix\BugphixLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class Bugphix extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bugphix';
    }
}
