<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emailing extends Model
{
    use HasFactory;

    protected $table = 'emailing';

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function send_to_employee()
    {
        return $this->belongsTo(User::class, 'to_user', 'employee_id');
    }

}
