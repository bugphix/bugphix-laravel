<p align="center"><a href="https://github.com/bugphix/bugphix-laravel" target="_blank" rel="noopener noreferrer"><img width="400" src="https://github.com/bugphix/documentation/blob/master/assets/big-logo.png" alt="Bugphix logo"></a></p>

<p align="center">
    <a href="https://circleci.com/gh/bugphix/bugphix-laravel" target="_blank"><img src="https://circleci.com/gh/bugphix/bugphix-laravel.svg?style=shield" alt="Build Status"></a>
    <a href="https://github.com/tterb/atomic-design-ui/blob/master/LICENSEs" target="_blank"><img src="https://img.shields.io/apm/l/atomic-design-ui.svg?" alt="MIT License"></a>
    <a href="#" target="_blank"><img src="https://img.shields.io/github/last-commit/google/skia.svg?style=flat" alt="GitHub last commit"></a>
    <a href="https://twitter.com/laravelarticle" target="_blank"><img src="https://badgen.net/badge/twitter/@laravelarticle/1DA1F2?icon&label" /></a>
    <a href="https://facebook.com/laravelarticle" target="_blank"><img src="https://badgen.net/badge/facebook/laravelarticle/3b5998"/></a>
    <a href="https://app.netlify.com/sites/bughix-docs/deploys" target="_blank"><img src="https://api.netlify.com/api/v1/badges/4338bd85-69e4-4008-b059-06cb1dcf94cc/deploy-status" alt="Netlify Status"></a>
</p>

<h3 align="center">Capture and monitor detailed error logs with nice dashboard and UI</h3>

<br>
<br>

<p align="center"><img width="800" src="https://github.com/bugphix/documentation/blob/master/assets/dashboard.gif" alt="Dashboard gif"></p>

#### Requirements

- [Check Laravel 6 requirements](https://laravel.com/docs/6.x#server-requirements)
- [Check Laravel 7 requirements](https://laravel.com/docs/7.x#server-requirements)

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

### Test Command
    $ php artisan bugphix:test

### View admin dashboard
http://localhost:8080/bugphix/issues

For full documentation: <a href="https://bugphix-docs.netlify.com" target="_blank" rel="noopener noreferrer">https://bugphix-docs.netlify.com</a>

## License

MIT

Copyright (c) 2020, Jeric
