<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskUser extends Model
{
    use HasFactory;

    protected $table = 'task_users';

    protected $fillable = ['task_id', 'user_id', 'requirement_id', 'created_at', 'updated_at'];

//    public function user()
//    {
//        return $this->belongsTo(User::class);
//    }
//
//    public function requirement()
//    {
//        return $this->belongsTo(Requirement::class);
//    }
//
//    public function task()
//    {
//        return $this->hasManyThrough(
//            Task::class,
//            TaskUser::class,
//            'user_id',
//            'id',
//            'id',
//            'task_id',
//        );
//    }

}
