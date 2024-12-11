<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Prompts\Progress;

class Portfolio extends Model
{
    use HasFactory;

    protected $table = 'portfolios';

    protected $fillable = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

}
