<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SemesterCourse extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($semesterCourse) {
            $semesterCourse->uuid = Str::uuid()->toString();
        });
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_uuid', 'uuid');
    }

    public function preRequisites()
    {
        return $this->hasMany(PreRequisite::class, 'semester_course_uuid', 'uuid');
    }

    public function coRequisites()
    {
        return $this->hasMany(CoRequisite::class, 'semester_course_uuid', 'uuid');
    }
}
