<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acknowledgement extends Model
{
    use HasFactory;
    protected $table = 'acknowledgement';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'batch_id',
        'trans_id',
        'office_id',
        'user_id',
    ];

    public function office()
    {
        return $this->belongsTo(Office::class, 'from_office_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'from_user', 'id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'batch_id', 'batch_id');
    }

    public function send_to_office()
    {
        return $this->belongsTo(Office::class, 'office_id', 'id');
    }


}
