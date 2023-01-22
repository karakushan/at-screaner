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
}
