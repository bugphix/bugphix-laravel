<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

$routePrefix = '\Bugphix\BugphixLaravel\Http\Controllers';

Route::group(['prefix' => 'api'], function () use ($routePrefix) {

    Route::group(['prefix' => 'bulk-update'], function () use ($routePrefix) {
        Route::put('issues/{ids}', "{$routePrefix}\IssuesController@bulkUpdate");
    });

    Route::group(['prefix' => 'bulk-delete'], function () use ($routePrefix) {
        Route::delete('issues/{ids}', "{$routePrefix}\IssuesController@bulkDelete");
    });

    Route::resource('projects', "{$routePrefix}\ProjectsController")->except(['create', 'edit']);
    Route::resource('issues', "{$routePrefix}\IssuesController")->except(['create', 'store', 'edit']);
    Route::resource('events', "{$routePrefix}\EventsController")->only(['index', 'show']);
    Route::resource('users', "{$routePrefix}\UsersController")->only(['index', 'show']);

    Route::get('get-project-list-options', "{$routePrefix}\BugphixController@getProjectListOptions");
    Route::get('get-active-project/{project_id?}', "{$routePrefix}\BugphixController@getActiveProject");
});

Route::get('/', "{$routePrefix}\BugphixController@home");
Route::get('/{any}', "{$routePrefix}\BugphixController@main")->where('any', '.*');
