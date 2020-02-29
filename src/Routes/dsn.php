<?php
/*
|--------------------------------------------------------------------------
| DSN api routes
|--------------------------------------------------------------------------
|
*/

Route::group([
    'prefix' => config('bugphix.option.dsn_slug')
], function(){

    $routePrefix = '\Bugphix\BugphixLaravel\Http\Controllers';
    Route::any('/{projectID}/{token}', "{$routePrefix}\DSNController@store");
});

