<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\News;
use Illuminate\Http\Request;

class StaffDashboardController extends Controller
{
    /**
     * Display the staff dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        $totalComplaints = Complaint::count();
        $assignedComplaints = Complaint::where('assigned_to', $user->id)->count();
        $pendingComplaints = Complaint::where('assigned_to', $user->id)
            ->where('status', 'pending')
            ->count();
        $inProgressComplaints = Complaint::where('assigned_to', $user->id)
            ->where('status', 'in_progress')
            ->count();
        $resolvedComplaints = Complaint::where('assigned_to', $user->id)
            ->where('status', 'resolved')
            ->count();
        $totalNews = News::where('user_id', $user->id)->count();

        return view('staff.dashboard', compact(
            'totalComplaints',
            'assignedComplaints',
            'pendingComplaints',
            'inProgressComplaints',
            'resolvedComplaints',
            'totalNews'
        ));
    }
}
