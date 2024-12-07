<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequirementUser extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'requirement_id', 'created_at', 'updated_at'];
}
