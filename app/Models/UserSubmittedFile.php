<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubmittedFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'size',
        'type',
        'file_path',
        'user_id',
        'requirement_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function requirement()
    {
        return $this->belongsTo(Requirement::class);
    }

    public function attachment()
    {
        return $this->belongsTo(Attachment::class);
    }
}
