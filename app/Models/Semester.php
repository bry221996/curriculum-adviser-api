<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Semester extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'id' => 'integer',
        'curriculum_id' => 'integer',
        'year' => 'integer',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($semester) {
            $semester->uuid = Str::uuid()->toString();
        });
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'semester_courses', 'semester_uuid', 'course_uuid', 'uuid', 'uuid');
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
