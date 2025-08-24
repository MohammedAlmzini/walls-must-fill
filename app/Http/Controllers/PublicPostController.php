<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\SEOService;
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

        $locale = session('locale', 'ar');
        $seoMeta = SEOService::getPageMeta('blog', [], $locale);
        
        return view('blog.index', compact('posts', 'q', 'seoMeta'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->where('is_published', true)->firstOrFail();
        
        $locale = session('locale', 'ar');
        $seoMeta = SEOService::getPageMeta('post', ['post' => $post], $locale);
        $structuredData = SEOService::generateStructuredData('article', ['post' => $post]);
        
        return view('blog.show', compact('post', 'seoMeta', 'structuredData'));
    }
}