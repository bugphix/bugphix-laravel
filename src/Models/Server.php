<?php

namespace Bugphix\BugphixLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    public $table = 'bugphix_servers';

    public $timestamps = false;

    protected $fillable = [
        'server_name',
        'server_os',
        'server_os_version',
        'server_runtime',
    ];
}
