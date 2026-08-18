<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class JobApplication extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'role',
        'availability',
        'portfolio_url',
        'resume_path',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function getResumeUrlAttribute(): ?string
    {
        return $this->resume_path ? Storage::disk('public')->url($this->resume_path) : null;
    }
}
