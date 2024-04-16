<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//ini adalah pivot table dari course dan user
class CourseStudent extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable =[
        'user_id',
        'course_id'
    ];


    // public function courses(){
    //     return $this->belongsToMany(Course::class,'course_students');
    // }
}
