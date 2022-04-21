<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'total_item',
        'grand_total',
        'user_id',
        'status',
    ];

    public function user()
    {
        # code...
        $this->belongsTo(User::class, 'user_id');
    }
}
