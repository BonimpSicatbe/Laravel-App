<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Staudenmeir\EloquentHasManyDeep\HasManyDeep;
use Znck\Eloquent\Relations\BelongsToThrough;

class Requirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'due_date',
        'created_by',
        'updated_by',
        'sent_to_type',
        'sent_to_id',
        'select_group',
        'select_target',
        'select_position',
        'select_person',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'status' => 'string',
    ];

    // ===== ADMIN =====

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'requirement_users',
        );
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'sent_to_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'sent_to_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'sent_to_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'requirement_id');
    }

    public function userSubmittedFiles()
    {
        return $this->hasMany(UserSubmittedFile::class, 'requirement_id');
    }

    // New relation for users who have submitted the requirement
    public function submittedUsers()
    {
        // Assuming there's a pivot table or a specific way to track submissions, adjust as necessary
        return $this->belongsToMany(User::class, 'requirement_user_submissions')  // Replace 'requirement_user_submissions' with the correct pivot table
            ->withTimestamps();  // Use this if you're tracking submission times
    }

    // =========================
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getSentToNameAttribute()
    {
        return match ($this->sent_to_type) {
            'course' => optional($this->course)->name ?? 'Course not found',
            'subject' => optional($this->subject)->name ?? 'Subject not found',
            'position' => optional($this->position)->name ?? 'Position not found',
            'all' => 'All Users',
            default => 'Not assigned',
        };
    }

    // ===== USER =====
}
