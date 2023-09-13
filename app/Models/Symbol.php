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

    public function exchanges()
    {
        return $this->belongsToMany(Exchange::class, 'exchange_symbols');
    }

    // symbol prices
    public function prices()
    {
        return $this->hasMany(SymbolPrice::class);
    }
}
