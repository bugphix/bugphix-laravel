<?php

namespace Bugphix\BugphixLaravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// models
use Bugphix\BugphixLaravel\Models\Project;

class Issue extends Model
{
    use SoftDeletes;

    public $table = 'bugphix_issues';

    protected $fillable = [
        'issue_project_id',
        'issue_error_exception',
        'issue_error_message',
        'issue_status',
    ];

    public function scopeProjectId($query, $projectId = '')
    {

        if ($projectId === '' || $projectId === 'default') {
            $project = Project::isActive()->first();
            if ($project) {
                $projectId = $project->project_id;
            }
        }

        return $query->where('issue_project_id', $projectId);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('issue_status', $status);
    }

    public function scopeIsUnresolved($query)
    {
        return $query->where('issue_status', 'unresolved');
    }

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public static function scopeSearchIssue($query, $keyword = '')
    {
        if (!$keyword) return $query;
        return $query->where('issue_error_exception', 'LIKE', "%$keyword%")
            ->orWhere('issue_error_message', 'LIKE', "%$keyword%");
    }
}
