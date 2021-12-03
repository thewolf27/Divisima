<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class MainController extends Controller
{
    public function __invoke(): View
    {
        $posts = Product::with('image')->take(10)->get();

        return view('main')->with([
            'title' => env("APP_NAME"),
            'posts' => $posts,
        ]);
    }
}
