<?php

return [
    /*
    |--------------------------------------------------------------------------
    | DSN - Update this link to pass the errors into another host
    | and by updating this link, admin dashboard inside this app
    | will automatically disabled.
    |
    | dsn will look like: https://bugphix.com/bphix-dsn/WIUF8/P5TK8NKEMO
    |--------------------------------------------------------------------------
    */
    'dsn' => env('BUGPHIX_DSN', ''),

    /*
    |--------------------------------------------------------------------------
    | Dashboard settings
    |--------------------------------------------------------------------------
    */
    'dashboard' => [
        'url' => env('BUGPHIX_DASHBOARD_URL', 'bugphix'), // Update this if you need to change the bugphix prefix
        'enable' => env('BUGPHIX_DASHBOARD_ENABLE', true), // If you need to hide the dashboard functions.
        // 'middleware' => ['auth'], // add middleware on your admin dashboard
        // 'logout_url' => env('APP_URL') . '/logout', // add logout link on your admin dashboard
    ],

    /*
    |--------------------------------------------------------------------------
    | Assets settings
    |--------------------------------------------------------------------------
    */
    'assets' => [
        'url' => env('APP_URL') . '/bugphix-assets' // modify this if you need to update the assets file path of bugphix
    ],

    /*
    |--------------------------------------------------------------------------
    | Project settings
    |--------------------------------------------------------------------------
    */
    'project' => [
        'length' => 5, // Min:5|Max:80, modify to change the length of unique id for each group
        'prefix' => '', // add custom prefix in generating group id
    ],

    /*
    |--------------------------------------------------------------------------
    | Miscellaneous
    |--------------------------------------------------------------------------
    */
    'option' => [
        'date_format' => 'D, M d,y H:i:s A e', // You can change the date format in api return response
        'dsn_slug' => '/bphix-dsn', // this will be slug url to get the requests coming from outside sources.
    ],
];
