<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function blog()
    {
        $posts = Post::orderBy('created_at','desc')->paginate(10);
        return view('blog.blog',[
            'title' => 'Blog page',
            'posts' => $posts,
        ]);
    }

    public function one(string $slug)
    {
        $post = Post::where('slug',$slug)->firstOrFail();

        return view('blog.one',[
            'title' => $post->title,
            'post' => $post,
        ]);
    }
}