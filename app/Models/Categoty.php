<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoty extends Model
{
    protected $guarded = [];

    public function course()
    {
        return $this->belongsToMany(Course::class, 'course_category');
    }
}
