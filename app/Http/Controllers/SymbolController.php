<?php

namespace App\Http\Controllers;

use App\Models\Symbol;
use Illuminate\Http\Request;

class SymbolController extends Controller
{
    function info($symbol){
        $symbol = Symbol::findOrfail($symbol);
        $title = $symbol->name;
        return view('symbol.info', compact('symbol', 'title'));
    }
}
