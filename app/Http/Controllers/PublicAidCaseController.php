<?php

namespace App\Http\Controllers;

use App\Models\AidCase;
use App\Services\SEOService;
use Illuminate\Http\Request;

class PublicAidCaseController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $cases = AidCase::when($q, fn($query) => $query->where('title','like',"%{$q}%"))
            ->latest()->paginate(9);

        $locale = session('locale', 'ar');
        $seoMeta = SEOService::getPageMeta('cases', [], $locale);
        
        return view('cases.index', compact('cases','q', 'seoMeta'));
    }

    public function show($slug)
    {
        $case = AidCase::where('slug', $slug)->with('images')->firstOrFail();
        
        $locale = session('locale', 'ar');
        $seoMeta = SEOService::getPageMeta('case', ['case' => $case], $locale);
        $structuredData = SEOService::generateStructuredData('fundraising', ['case' => $case]);
        
        return view('cases.show', compact('case', 'seoMeta', 'structuredData'));
    }
}