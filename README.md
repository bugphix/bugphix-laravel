<p align="center"><a href="https://github.com/bugphix/bugphix-laravel" target="_blank" rel="noopener noreferrer"><img width="400" src="https://github.com/bugphix/documentation/blob/master/assets/big-logo.png" alt="Bugphix logo"></a></p>

[![Bugphix](https://circleci.com/gh/bugphix/bugphix-laravel.svg?style=shield)](https://circleci.com/gh/bugphix/bugphix-laravel)
[![MIT License](https://img.shields.io/apm/l/atomic-design-ui.svg?)](https://github.com/tterb/atomic-design-ui/blob/master/LICENSEs)
[![GitHub last commit](https://img.shields.io/github/last-commit/google/skia.svg?style=flat)]()
[![Netlify Status](https://api.netlify.com/api/v1/badges/4338bd85-69e4-4008-b059-06cb1dcf94cc/deploy-status)](https://app.netlify.com/sites/bughix-docs/deploys)

<h3 align="center">Capture and monitor detailed error logs with nice dashboard and UI</h3>

<br>
<br>

<p align="center"><img width="800" src="https://github.com/bugphix/documentation/blob/master/assets/dashboard.gif" alt="Dashboard gif"></p>

#### Requirements
- Currently tested working with Laravel 6

## Installation
    $ composer require bugphix/bugphix-laravel

### Publish config files
    $ php artisan vendor:publish --tag=bugphix-config

### Run artisan installer
    $ php artisan bugphix:install

### Application usage    
edit: /app/Exceptions/Handler.php
    
    public function report(Exception $exception)
    {
        if (app()->bound('bugphix') && $this->shouldReport($exception)) {
            app('bugphix')->catchError($exception);
        }

        parent::report($exception);
    }

### View admin dashboard
http://localhost:8080/bugphix/issues

For full documentation: <a href="https://bugphix-docs.netlify.com" target="_blank" rel="noopener noreferrer">https://bugphix-docs.netlify.com</a>

## License

MIT

Copyright (c) 2020, Jeric
