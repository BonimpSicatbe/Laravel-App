<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'course_user',
            'course_id',
            'user_id'
        );
    }

    // --------------------

}
