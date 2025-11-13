<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Task extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'title',
        'description', 
        'status',
        'project_id',
        'user_id',
        'due_date',
        'link'
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'description', 'status', 'project_id', 'user_id', 'due_date', 'link'])
            ->logOnlyDirty();
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dailyWorkLogs()
    {
        return $this->hasMany(DailyWorkLog::class);
    }

    public function reviews()
    {
        return $this->hasMany(TaskReview::class);
    }

    public function problems()
    {
        return $this->hasMany(Problem::class);
    }
}