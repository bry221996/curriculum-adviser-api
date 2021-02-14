<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Semester extends Model
{
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
}
