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

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'account_number',
        'name',
        'role',
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
        return $this->hasMany(Requirement::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(
            Task::class,
            'task_users',
        );
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function courses()
    {
        return $this->belongsTo(Course::class, 'course_users');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_users');
    }

    public function position()
    {
        return $this->hasOne(Position::class, 'position_users');
    }

    // =========================
//    /*
//     *
//     * HAS ONE
//     *
//     * */
//
//    public function positionUser(): HasOne
//    {
//        return $this->hasone(PositionUser::class);
//    }
//
//    /*
//     *
//     * BELONGS TO MANY
//     *
//     * */
//
//
//    /*
//     *
//     * HAS MANY
//     *
//     * */
//
//
//    public function requirementUsers(): HasMany
//    {
//        return $this->hasMany(RequirementUser::class);
//    }
//
//    public function notifications(): HasMany
//    {
//        return $this->hasMany(Notification::class);
//    }
//
//    public function subjectUsers(): HasMany
//    {
//        return $this->hasMany(SubjectUser::class);
//    }
//
//    public function folders(): HasMany
//    {
//        return $this->hasMany(Folder::class);
//    }


    /*
     *
     * HAS MANY THROUGH
     *
     * */

//    public function tasks(): HasManyThrough
//    {
//        return $this->hasManyThrough(Task::class, Requirement::class);
//    }
}
