<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'logdate',
        'logtime',
        'remarks',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* public function getTypeAttribute($value)
    {
        $types = [
            1 => 'Electricity',
            2 => 'Gas',
            3 => 'Water',
            4 => 'Internet',
            5 => 'Phone',
            6 => 'Others',
        ];

        return $types[$value];
    } */

    public function getLogDateTimeAttribute()
    {
        return $this->logdate . ' ' . $this->logtime;
    }
    
}
