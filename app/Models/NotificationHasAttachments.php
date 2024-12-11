<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationHasAttachments extends Model
{
    use HasFactory;

    protected $fillable = ['notification_id', 'attachment_id', 'created_at', 'updated_at'];

    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }

    public function attachments()
    {
        return $this->hasManyThrough(
            Attachment::class,
            NotificationHasAttachments::class,
            'notification_id',
            'id',
            'id',
            'attachment_id',
        );
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
