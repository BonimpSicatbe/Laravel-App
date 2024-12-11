<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'message', 'sent_to', 'created_by', 'updated_by'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_has_notifications')
            ->withPivot('read_at') // Include the 'read_at' column from the pivot table
            ->withTimestamps();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
