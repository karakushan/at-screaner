<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    function home()
    {
        $title = 'Home';
        return view('welcome', compact('title'));
    }
}
