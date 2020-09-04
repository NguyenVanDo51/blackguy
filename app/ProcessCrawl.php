<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcessCrawl extends Model
{

    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';

    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
