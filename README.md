<p align="center"><a href="https://github.com/bugphix/bugphix-laravel" target="_blank" rel="noopener noreferrer"><img width="400" src="https://github.com/bugphix/bugphix-laravel/blob/master/docs/images/logo.png" alt="Bugphix logo"></a></p>

<p align="center"><img width="800" src="https://github.com/bugphix/bugphix-laravel/blob/master/docs/images/dashboard.gif" alt="Dashboard gif"></p>

<h3 align="center">Capture and monitor detailed error logs with nice dashboard and UI</h3>

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

For full documentation: <a href="https://bugphix.github.io/bugphix-laravel" target="_blank" rel="noopener noreferrer">https://bugphix.github.io/bugphix-laravel</a>

## License

MIT

Copyright (c) 2020, Jeric
