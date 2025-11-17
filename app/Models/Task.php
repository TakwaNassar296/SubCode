<?php

namespace App\Models;

use App\Models\Problem;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory, LogsActivity , SoftDeletes;

    protected $fillable = [
        'title',
        'description', 
        'status',
        'project_id',
        'user_id',
        'due_date',
        'link',
        'has_problem',
        'problem_description',
    ];

    protected $casts = [
        'due_date' => 'date',
        'has_problem' => 'boolean',
    ];


    protected static function booted()
    {
        parent::booted();

        static::saved(function ($task) {
            $hasProblem = $task->has_problem ;
            $problemDescription = $task->problem_description ?? null;


            if ($hasProblem && ! $task->problems()->exists()) {

               
                Problem::create([
                    'task_id'     => $task->id,
                    'title'       => $task->title,
                    'description' => $problemDescription ?? 'Auto generated problem',
                    'reported_by' => auth()->id(),
                    'status'      => 'pending',
                ]);
            }
        });
    }


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