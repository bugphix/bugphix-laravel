<p align="center"><a href="https://github.com/bugphix/bugphix-laravel" target="_blank" rel="noopener noreferrer"><img width="400" src="https://github.com/bugphix/bugphix-laravel/blob/master/assets/images/logo.png" alt="Bugphix logo"></a></p>


<h3 align="center">Capture and monitor detailed error logs with nice dashboard and UI</h3>

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

## License

MIT

Copyright (c) 2020, Jeric
