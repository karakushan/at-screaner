<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function main()
    {
        $title = 'Blog';
        $description = 'Blog description';

        return view('blog.main', compact('title', 'description'));
    }
}
