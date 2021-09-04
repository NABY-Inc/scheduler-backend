<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
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
     * Get all of the lecturerCourses for the Department
     */
    public function lecturerCourses()
    {
        return $this->hasMany(LecturerCourse::class);
    }
}
