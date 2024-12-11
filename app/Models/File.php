<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Znck\Eloquent\Relations\BelongsToThrough;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'mime_type',
        'size',
        'task_id',
        'folder_id'
    ];

    protected $casts = [
        'size' => 'integer',          // Assuming size is in bytes and is stored as an integer
        'task_id' => 'integer',
        'folder_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

// =========================
    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    public function fileSize(): BelongsTo
    {
        return $this->belongsTo(File::class, 'size');
    }

    public function requirement(): BelongsToThrough
    {
        return $this->belongsToThrough(Requirement::class, Task::class);
    }
}
