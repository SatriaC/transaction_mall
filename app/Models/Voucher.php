<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    protected $fillable = [
        'transaction_id',
        'code',
        'amount',
        'expired_at',
    ];

    public function transaction()
    {
        # code...
        $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
