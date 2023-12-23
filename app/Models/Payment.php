<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'user_id',
        'status' ,
        'sub_total',
        'total' ,
        'charge_id',
        'payment_intent_id',
        'response_message',
        'type',
        'sub_type',
        'transaction_id',
        'transaction_number',
        'paymentable_type',
        'paymentable_id'
    ];

    public function paymentable(): MorphTo
    {
        return $this->morphTo();
    }
}
