<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug'];

    public function symbols()
    {
        return $this->belongsToMany(Symbol::class, 'exchange_symbols');
    }
}
