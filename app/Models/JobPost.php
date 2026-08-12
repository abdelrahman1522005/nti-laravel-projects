<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'category_id',
        'title',
        'description',
        'required_skills',
        'location',
        'work_type',
        'salary',
        'application_deadline',
    ];

    protected $casts = [
        'required_skills' => 'array',
        'application_deadline' => 'date',
        'salary' => 'decimal:2',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function isOpen(): bool
    {
        return is_null($this->application_deadline) || $this->application_deadline->isFuture();
    }
}