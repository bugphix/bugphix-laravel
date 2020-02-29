<?php

namespace Bugphix\BugphixLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $table = 'bugphix_clients';

    public $timestamps = false;

    protected $fillable = [
        'client_method',
        'client_url',
        'client_browser',
        'client_browser_version',
        'client_os',
        'client_ip',
        'client_header',
    ];

    protected $casts = [
        'client_header' => 'array',
    ];
}
