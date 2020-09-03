<?php

namespace App;

use App\Models\Course;
use App\Models\Lession;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function courses()
    {
        return $this->belongstoMany(Course::class, 'course_user')
            ->using(CourseUser::class)
            ->withPivot('latest')
            ->withTimestamps();
    }

    public function lessions()
    {
        return $this->belongsToMany(Lession::class)
            ->using(LessionUser::class)
            ->withPivot(['timer', 'course'])
            ->withTimestamps();
    }
}
