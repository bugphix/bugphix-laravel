<?php

namespace Bugphix\BugphixLaravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Project extends Model
{
    use SoftDeletes;

    public $table = 'bugphix_projects';

    protected $fillable = [
        'project_id',
        'project_name',
        'project_description',
        'project_platform',
        'project_token',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeCreateProject($query, array $options = [])
    {

        if (count($options) === 0) return;

        if (!isset($options['project_name'])) return;

        return $query->create([
            'project_id' => $this->generateprojectId(),
            'project_name' => $options['project_name'],
            'project_platform' => $options['project_platform'] ?? 'laravel',
            'project_description' => $options['project_description'] ?? null,
            'project_token' => $this->generateToken(),
        ]);
    }

    public function scopeSearchProject($query, $keyword = '')
    {
        if (!$keyword) return $query;
        return $query->where('project_id', 'LIKE', "%$keyword%")
            ->orWhere('project_name', 'LIKE', "%$keyword%");
    }

    public function scopeIsActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeProjectId($query, string $projectId)
    {
        return $query->where('project_id', $projectId);
    }

    public function scopeProjectToken($query, $token)
    {
        return $query->where('project_token', $token);
    }

    private function generateToken()
    {
        while (1) {
            $token = strtoupper(Str::random(10));
            if (self::where('project_token', $token)->first() == '') break;
        }
        return $token;
    }

    private function generateProjectId()
    {
        $projectIdLength = config('bugphix.project.length');
        $projectPrefix = config('bugphix.project.prefix') ?? '';

        if ($projectIdLength < 5) $projectIdLength = 5;
        if ($projectIdLength > 80) $projectIdLength = 80;

        while (1) {
            $projectId = $projectPrefix . strtoupper(Str::random($projectIdLength));
            if (self::where('project_id', $projectId)->first() == '') break;
        }
        return $projectId;
    }
}
