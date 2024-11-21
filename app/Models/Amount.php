<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amount extends Model
{
    use HasFactory;
    protected $table = 'thesis_amount';

    protected $fillable = [
    'transaction_id',
    'student_id',
    'member_id',
    'adviser_id',
    'chairperson_id',
    'recorder_id',
    'amount',
    'created_by',
    'updated_by',
    ];
}
