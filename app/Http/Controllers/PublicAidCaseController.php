<?php

namespace App\Http\Controllers;

use App\Models\AidCase;
use Illuminate\Http\Request;

class PublicAidCaseController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $cases = AidCase::when($q, fn($query) => $query->where('title','like',"%{$q}%"))
            ->latest()->paginate(9);
        return view('cases.index', compact('cases','q'));
    }

    public function show($slug)
    {
        $case = AidCase::where('slug', $slug)->with('images')->firstOrFail();
        return view('cases.show', compact('case'));
    }
}