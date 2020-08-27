<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_tag');
    }
}
