<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AidCase;
use App\Models\Post;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'posts' => Post::count(),
            'cases' => AidCase::count(),
            'completed_cases' => AidCase::where('is_completed', true)->count(),
            'donations_sum' => AidCase::sum('collected_amount'),
        ];
        return view('admin.dashboard', compact('stats'));
    }
}