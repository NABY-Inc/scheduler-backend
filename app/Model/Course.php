<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];
    
    /**
     * Get the department that owns the Course
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the lecturerCourse associated with the Course
     */
    public function lecturerCourse()
    {
        return $this->hasOne(LecturerCourse::class);
    }

}
