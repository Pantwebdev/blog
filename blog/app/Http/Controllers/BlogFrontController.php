<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogFrontController extends Controller
{
    //
   public function index()
{
    $posts = BlogPost::latest()->paginate(10); // ✅ Enables pagination and ->links()
    return view('blog.index', compact('posts'));
}

    public function show($slug)
    {
        $post = BlogPost::where('url', $slug)->firstOrFail();
        return view('blog.show', compact('post'));
    }
}
