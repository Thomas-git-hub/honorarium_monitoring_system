<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'thesis_member';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'member_type',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
       
    ];

}
