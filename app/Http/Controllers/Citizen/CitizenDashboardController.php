<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\News;
use Illuminate\Http\Request;

class CitizenDashboardController extends Controller
{
    /**
     * Display the citizen dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        $totalComplaints = Complaint::where('user_id', $user->id)->count();
        $pendingComplaints = Complaint::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();
        $inProgressComplaints = Complaint::where('user_id', $user->id)
            ->where('status', 'in_progress')
            ->count();
        $resolvedComplaints = Complaint::where('user_id', $user->id)
            ->where('status', 'resolved')
            ->count();

        $recentComplaints = Complaint::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $publishedNews = News::where('status', 'published')
            ->latest()
            ->take(5)
            ->get();

        return view('citizen.dashboard', compact(
            'totalComplaints',
            'pendingComplaints',
            'inProgressComplaints',
            'resolvedComplaints',
            'recentComplaints',
            'publishedNews'
        ));
    }
}
