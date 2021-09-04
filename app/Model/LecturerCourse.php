<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LecturerCourse extends Model
{
    protected $guarded = [];

    /**
     * Get the lecturer that owns the Course
     */
    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }
    
    /**
     * Get the course that owns the Course
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    
}
