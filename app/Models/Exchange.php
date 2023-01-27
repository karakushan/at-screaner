<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'trade_link', 'logo_url'];


    public function symbols()
    {
        return $this->belongsToMany(Symbol::class, 'exchange_symbols');
    }

    public function getTradeUrl($base, $quote)
    {
        return str_replace(['{base}', '{quote}'], [$base, $quote], $this->trade_link);
    }

    function deleteLogo()
    {
        if ($this->logo_url && \Storage::disk('public')->exists($this->logo_url)) {
            \Storage::disk('public')->delete($this->logo_url);
        }
    }

    // currencies
    public function currencies()
    {
        return $this->hasMany(Currency::class);
    }

    // exchange currency
    public function getCurrency($name)
    {
        return $this->currencies()->where('name', $name)->first();
    }

    // display currency info
    public function displayCurrency($name, $separator = ':')
    {
        $currency = $this->getCurrency($name);
        if (!$currency) return '';

        $chunks = [
            '<span title="chain">'.$currency->chain.'</span>',
            '<span title="withdraw" class="' . ($currency->withdraw_disabled ? 'text-red-500' : 'text-green-600') . '">W</span>',
            '<span title="deposit" class="' . ($currency->deposit_disabled ? 'text-red-500' : 'text-green-600') . '">D</span>'
        ];

        return '<span class="text-gray-500 opacity-80 font-semibold">(' . implode($separator, $chunks) . ')</span>';
    }

}
