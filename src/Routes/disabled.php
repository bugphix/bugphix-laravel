<?php
/*
|--------------------------------------------------------------------------
| Make all bugphix route disabled
| if environment is not "local"
| and admin slug is still "bugphix"
|--------------------------------------------------------------------------
|
*/
Route::get('/{any?}', function () {
    abort(403);
});
