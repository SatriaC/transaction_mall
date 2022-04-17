<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardingHouse extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'boarding_house';
    protected $fillable = [
        'name',
        'user_id',
        'location',
        'price',
        'qty',
        'type',
        'description',
        'status'
    ];

    public function owner()
    {
        # code...
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getStatusAttribute($value)
    {
        # code...
        return $value == 1 ? 'Available' : 'Not Available';
    }
}
