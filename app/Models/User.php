<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

protected $casts = [
    'email_verified_at' => 'datetime',
];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isCandidate(): bool
    {
        return $this->role === 'candidate';
    }

    public function candidateProfile()
    {
        return $this->hasOne(CandidateProfile::class);
    }

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class, 'admin_id');
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }
}