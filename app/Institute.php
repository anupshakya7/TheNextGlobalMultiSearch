<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Institute extends Model
{
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function course()
    {
        return $this->belongsToMany(Course::class,'course_institute','institute_id','course_id');
    } 
}
