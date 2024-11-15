<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'account_number',
        'name',
        'position',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function requirements()
    {
        return $this->hasManyThrough(
            Requirement::class,
            RequirementUser::class,
            'user_id',
            'id',
            'id',
            'requirement_id',
        );
    }

    public function tasks()
    {
        return $this->hasManyThrough(
            Task::class,
            RequirementUser::class,
            'user_id',
            'requirement_id',
            'id',
            'id'
        );
    }

    public function position()
    {
        return $this->hasOneThrough(
            Position::class,
            PositionUser::class,
            'user_id',
            'id',
            'id',
            'position_id',
        );
    }

    public function courses()
    {
        return $this->hasManyThrough(
            Course::class,
            CourseUser::class,
            'user_id',
            'id',
            'id',
            'course_id',
        );
    }

    public function subjects()
    {
        return $this->hasManyThrough(
            Subject::class,
            SubjectUser::class,
            'user_id',
            'id',
            'id',
            'subject_id',
        );
    }
    // ====================

}
