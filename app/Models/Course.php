<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'units' => 'integer',
        'lecture_hours' => 'integer',
        'laboratory_hours' => 'integer',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($course) {
            $course->uuid = Str::uuid()->toString();
        });
    }
}
