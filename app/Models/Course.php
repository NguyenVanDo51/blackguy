<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_user');
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Categoty::class, 'course_category');
    }

    public function lessions()
    {
        return $this->hasMany(Lession::class);
    }

    public function author()
    {
        return $this->hasOne(Author::class);
    }
}
