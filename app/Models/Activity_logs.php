<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity_logs extends Model
{
    use HasFactory;

    protected $table = 'activity_logs';

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
