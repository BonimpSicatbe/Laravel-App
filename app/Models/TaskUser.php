<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskUser extends Model
{
    use HasFactory;

    protected $table = 'task_users';

    protected $fillable = ['task_id', 'user_id', 'requirement_id'];

    public function tasks(Task $task)
    {
        return $this->hasMany(
            TaskUser::class,
            'user_id',
            'task_id',
        );
    }
}
