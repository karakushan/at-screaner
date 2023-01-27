<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'exchange_id',
        'chain',
        'delisted',
        'withdraw_disabled',
        'deposit_disabled',
        'trade_disabled',
        'description',
        'logo'
    ];


    public function exchange()
    {
        return $this->belongsTo(Exchange::class);
    }
}
