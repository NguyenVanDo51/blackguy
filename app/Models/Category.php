<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'category_tag');
    }
}
