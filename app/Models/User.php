<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
 

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable ,  HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'github_account',
        'working_hours',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_user');
    }

       public function tasks()
    {
        return $this->hasMany(Task::class);
    }


    public function dailyWorkLogs()
    {
        return $this->hasMany(DailyWorkLog::class);
    }

    public function taskReviews()
    {
        return $this->hasMany(TaskReview::class, 'reviewer_id');
    }

    public function reportedProblems()
    {
        return $this->hasMany(Problem::class, 'reported_by');
    }

    public function solvedProblems()
    {
        return $this->hasMany(Problem::class, 'solved_by');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true; 
    }
}
