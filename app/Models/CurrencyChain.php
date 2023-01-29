<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyChain extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'can_deposit',
        'can_withdraw',
        'withdraw_fee',
        'deposit_min',
        'withdraw_min',
        'exchange_id',
        'currency_id'
    ];

    protected $casts = [
        'can_deposit' => 'boolean',
        'can_withdraw' => 'boolean',
        'withdraw_fee' => 'float',
        'deposit_min' => 'float',
        'withdraw_min' => 'float',
    ];
}
