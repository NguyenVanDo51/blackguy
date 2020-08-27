<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseUser extends Pivot
{
    public $incrementing = true;
}
