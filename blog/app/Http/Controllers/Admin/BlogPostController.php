<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mews\Purifier\Facades\Purifier;

class BlogPostController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = BlogPost::query();

        // If there's a search keyword
        if ($request->has('search') && $request->search != '') {
            $keyword = $request->search;

            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%$keyword%")
                    ->orWhere('meta_title', 'LIKE', "%$keyword%")
                    ->orWhere('meta_description', 'LIKE', "%$keyword%")
                    ->orWhere('description', 'LIKE', "%$keyword%");
            });
        }

        // Don't overwrite the query – apply latest and paginate on the filtered results
        $posts = $query->latest()->paginate(5);

        return view('admin.posts.index', compact('posts'));
    }


    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255|unique:blog_posts,url',
            'description' => 'required',
            'image' => 'required|image',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
        ]);

        $data['url'] = Str::slug(title: $request->title);
        $cleanHTML = Purifier::clean($request->description);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('posts', $fileName, 'public');
            $data['image'] = $path;
        }
        try {
            // BlogPost::create($data);
            BlogPost::create([
                'title' => $request->title,
                'url' => $request->url, // now coming from form
                'description' => $cleanHTML,
                'image' => $path,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
            ]);
            return redirect()->route('admin.posts.index')->with("success", "Post Created Successfully!");
        } catch (QueryException $e) {
            if ($e->getCode() == 2300) {
                return back()->with('warning', 'A blog post with the same URL already exists.');
            }
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function edit(BlogPost $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($post->title !== $data['title']) {
            $data['url'] = Str::slug($data['title']);
        }
        $data['url'] = Str::slug($request->title);
        $data['description'] = \Purifier::clean($data['description']);

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully!');
    }

    public function destroy(BlogPost $post)
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted!');
    }

    public function checkUrl(Request $request)
    {
        $exists = BlogPost::where('url', $request->url)->exists();
        return response()->json(['available' => !$exists]);
    }
    public function show($id)
    {
        // Agar use nahi karna, to bas redirect kar do
        return redirect()->route('admin.posts.index');
    }
}
