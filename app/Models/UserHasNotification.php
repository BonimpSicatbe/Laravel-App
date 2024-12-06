<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHasNotification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'notification_id', 'created_at', 'updated_at'];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function notification()
    {
        $this->belongsTo(Notification::class);
    }
}
