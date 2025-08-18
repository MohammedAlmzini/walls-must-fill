<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PublicPostController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $posts = Post::where('is_published', true)
            ->when($q, fn($query) => $query->where('title', 'like', "%{$q}%"))
            ->latest('published_at')
            ->paginate(9);
        return view('blog.index', compact('posts', 'q'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return view('blog.show', compact('post'));
    }
}