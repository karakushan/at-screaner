<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SymbolPrice extends Model
{
    use HasFactory;

    protected $casts = [
        'price' => 'float',
    ];

    protected $fillable = [
        'symbol_id',
        'exchange_id',
        'price',
    ];

    protected $appends = [
        'exchange_name',
        'price_formatted',
    ];

    // exchange
    public function exchange()
    {
        return $this->belongsTo(Exchange::class);
    }

    // attribute exchange name
    public function getExchangeNameAttribute(): string
    {
        return $this->exchange->name ?? '';
    }

    // attribute price formatted
    public function getPriceFormattedAttribute(): string
    {
        return sprintf("%.8f", $this->price);
    }

}
