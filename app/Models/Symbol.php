<?php

namespace App\Models;

use Barryvdh\Debugbar\Twig\Extension\Debug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Symbol extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'base_currency',
        'quote_currency',
    ];

    protected $appends = [
        'spread',
    ];

    public function exchanges()
    {
        return $this->belongsToMany(Exchange::class, 'exchange_symbols');
    }

    // symbol prices
    public function prices()
    {
        return $this->hasMany(SymbolPrice::class);
    }

    // calculate spread between prices
    public function getSpreadAttribute(): float
    {
        if ($this->prices->count() < 2) {
            return 0;
        }
        $prices = $this->prices->pluck('price')->toArray();

        if (min($prices) == 0) {
            return 0;
        }

        $spread = (max($prices) - min($prices)) / min($prices) * 100;


        return round($spread, 2);
    }
}
