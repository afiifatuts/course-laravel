<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    //user dapat memasukkan data apa saja yang membahayakan sistem 
    protected $guarded = [
        'id',
    ];

    //ORM(Object Relational Model)
    public function courses(){
        return $this->hasMany(Course::class);
    }   
}
