<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use App\LessionUser;

class Lession extends Model
{
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->using(LessionUser::class)
            ->withPivot(['timer', 'course'])
            ->withTimestamps();
    }
}
