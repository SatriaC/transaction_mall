<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $table = 'transaction_detail';
    protected $fillable = [
        'transaction_id',
        'item_id',
        'qty',
        'total',
    ];
    public function transaction()
    {
        # code...
        $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function item()
    {
        # code...
        $this->belongsTo(Item::class, 'item_id');
    }
}
