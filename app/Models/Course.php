<?php

namespace App\Models;

use App\CourseUser;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];

    public $timestamps = true;

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_user')
            ->using(CourseUser::class)
            ->withPivot('latest')
            ->withTimestamps();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function lessions()
    {
        return $this->hasMany(Lession::class);
    }


}
