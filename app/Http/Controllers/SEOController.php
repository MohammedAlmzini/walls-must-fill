<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\AidCase;
use Illuminate\Http\Response;

class SEOController extends Controller
{
    public function sitemap()
    {
        $posts = Post::where('is_published', true)->latest('updated_at')->get();
        $cases = AidCase::latest('updated_at')->get();

        $content = view('seo.sitemap', compact('posts', 'cases'))->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }

    public function robots()
    {
        $content = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin/\n";
        $content .= "Disallow: /storage/\n";
        $content .= "Disallow: /vendor/\n";
        $content .= "Disallow: /_debugbar/\n";
        $content .= "\n";
        $content .= "Sitemap: " . url('/sitemap.xml') . "\n";

        return response($content, 200)
            ->header('Content-Type', 'text/plain');
    }
}