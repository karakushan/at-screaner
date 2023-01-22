<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    function home()
    {
        $title = __('Cryptocurrency arbitrage scanner (screener)');
        $description = __('Scanner (screener) of bundles and spreads for cryptocurrency arbitrage on exchanges');

        return view('welcome', compact('title', 'description'));
    }

    function page($slug)
    {
        $title = __('Page');
        $description = __('Page');

        return view('page.single', compact('title', 'description'));
    }
}
