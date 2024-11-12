<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'thesis_student';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'status',
        'created_by',
        'created_on',
        'updated_by',
        'updated_on'
       
    ];

}
