<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreRequisite extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_uuid', 'uuid');
    }
}
