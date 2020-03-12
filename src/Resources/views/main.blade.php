<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>Bugphix</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @if(!Bugphix::isAssetsExists())
            <style>
                body{
                    margin: 0;
                    padding:0;
                    background: #f2f7ff;
                    font-family: BlinkMacSystemFont,-apple-system,Segoe UI,Roboto,Oxygen,Ubuntu,Cantarell,Fira Sans,Droid Sans,Helvetica Neue,Helvetica,Arial,sans-serif;
                }
                .assets-not-found{
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                }
                .assets-not-found .content{
                    background-color: #fff;
                    box-shadow: 0 0.5em 1em -0.125em rgba(10,10,10,.1), 0 0 0 1px rgba(10,10,10,.02);
                    color: #4a4a4a;
                    padding: 1rem;
                }
                .assets-not-found code{
                    padding: 5px 10px;
                    background: #eee;
                }
            </style>
        @else
            <link rel="stylesheet" href="{{Bugphix::asset('/plugins/@mdi/font/css/materialdesignicons.min.css')}}">
            <link rel="stylesheet" href="{{Bugphix::asset('/css/app.css')}}">

            <link rel="apple-touch-icon" sizes="57x57" href="{{Bugphix::asset('/images/favicon/apple-icon-57x57.png')}}">
            <link rel="apple-touch-icon" sizes="60x60" href="{{Bugphix::asset('/images/favicon/apple-icon-60x60.png')}}">
            <link rel="apple-touch-icon" sizes="72x72" href="{{Bugphix::asset('/images/favicon/apple-icon-72x72.png')}}">
            <link rel="apple-touch-icon" sizes="76x76" href="{{Bugphix::asset('/images/favicon/apple-icon-76x76.png')}}">
            <link rel="apple-touch-icon" sizes="114x114" href="{{Bugphix::asset('/images/favicon/apple-icon-114x114.png')}}">
            <link rel="apple-touch-icon" sizes="120x120" href="{{Bugphix::asset('/images/favicon/apple-icon-120x120.png')}}">
            <link rel="apple-touch-icon" sizes="144x144" href="{{Bugphix::asset('/images/favicon/apple-icon-144x144.png')}}">
            <link rel="apple-touch-icon" sizes="152x152" href="{{Bugphix::asset('/images/favicon/apple-icon-152x152.png')}}">
            <link rel="apple-touch-icon" sizes="180x180" href="{{Bugphix::asset('/images/favicon/apple-icon-180x180.png')}}">
            <link rel="icon" type="image/png" sizes="192x192"  href="{{Bugphix::asset('/images/favicon/android-icon-192x192.png')}}">
            <link rel="icon" type="image/png" sizes="32x32" href="{{Bugphix::asset('/images/favicon/favicon-32x32.png')}}">
            <link rel="icon" type="image/png" sizes="96x96" href="{{Bugphix::asset('/images/favicon/favicon-96x96.png')}}">
            <link rel="icon" type="image/png" sizes="16x16" href="{{Bugphix::asset('/images/favicon/favicon-16x16.png')}}">
            <meta name="msapplication-TileImage" content="{{Bugphix::asset('/images/favicon/ms-icon-144x144.png')}}">
        @endif
    </head>
    <body>
        @if(!Bugphix::isAssetsExists())
            <div class="assets-not-found">
                <div class="content">
                    <p>We're sorry but Bugphix can't locate the assets folder, <strong>[{{Bugphix::asset('/')}}]</strong> make sure you have properly set it via config.</p>
                    <p>or you can run <code>$ php artisan bugphix:assets-symlink</code> manually to install the assets.
                </div>
            </div>
        @else
            <noscript>
                <strong>We're sorry but Bugphix doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
            </noscript>
            <div id="bugphix-app"><app></app></div>
            <script type="text/javascript">
                @php
                    $bugphixOptions = array(
                        'main' => url('/'),
                        'urlPrefix' => trim(config('bugphix.dashboard.url')),
                        'api' => url(trim(config('bugphix.dashboard.url')) .'/api'),
                        'logout_url' => url(trim(config('bugphix.dashboard.logout_url'))) ?? '',
                        'dsn_slug' => trim(url(config('bugphix.option.dsn_slug'))),
                        'assets_url' => Bugphix::asset('/'),
                    );
                @endphp
                window.Bugphix =  Object.freeze(JSON.parse( `{!!json_encode($bugphixOptions)!!}` ));
            </script>
            <script type="text/javascript" src="{{Bugphix::asset('/js/app.js')}}"></script>
        @endif
    </body>
</html>
