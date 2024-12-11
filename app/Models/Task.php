<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = ['name', 'description', 'due_date', 'status', 'priority', 'image_path', 'user_id', 'created_by', 'updated_by', 'requirement_id'];

    protected $casts = [
        'name' => 'string',
        'description' => 'string',
        'due_date' => 'datetime',
        'status' => 'string',
        'priority' => 'string',
        'user_id' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'requirement_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tasks_users', 'task_id', 'user_id');
    }

    public function users() // 17/10/2024 9:32am
    {
        return $this->belongsToMany(
            User::class,
            'task_users',
        );
    }

    public function requirement()
    {
        return $this->belongsTo(Requirement::class);
    }

    public function files()
    {
        return $this->hasMany(
            File::class,
        );
    }

    // =========================
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(
            Attachment::class
        );
    }

    public function folders(): HasMany
    {
        return $this->hasMany(Folder::class);
    }
}
