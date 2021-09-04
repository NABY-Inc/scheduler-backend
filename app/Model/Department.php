<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = [];

    /**
     * Get all of the courses for the Department
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
    
    /**
     * Get all of the lecturers for the Department
     */
    public function lecturers()
    {
        return $this->hasMany(Lecturer::class);
    }
}
