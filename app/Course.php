<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Course extends Model
{
    public function institute()
    {
        return $this->belongsToMany(Institute::class,'course_institute','course_id','institute_id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class,'level','id');
    }
}
