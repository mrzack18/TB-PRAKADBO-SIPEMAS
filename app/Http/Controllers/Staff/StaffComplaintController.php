<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StaffComplaintController extends Controller
{
    /**
     * Display a listing of complaints assigned to the staff member.
     */
    public function index()
    {
        $user = Auth::user();
        $complaints = Complaint::where('assigned_to', $user->id)
            ->with(['user', 'assignedUser'])
            ->latest()
            ->get();

        return view('staff.complaints.index', compact('complaints'));
    }

    /**
     * Show the form for creating a new complaint.
     */
    public function create()
    {
        $users = User::where('role', '!=', 'staf_desa')->get(); // Exclude staff from complainants
        return view('staff.complaints.create', compact('users'));
    }

    /**
     * Store a newly created complaint in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:2048',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,in_progress,resolved,rejected',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'status' => $request->status,
            'assigned_to' => Auth::id(), // Assign to current staff member
        ];

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('complaints', 'public');
            $data['attachment'] = $attachmentPath;
        }

        Complaint::create($data);

        return redirect()->route('staff.complaints.index')->with('success', 'Pengaduan berhasil dibuat.');
    }

    /**
     * Display the specified complaint.
     */
    public function show(Complaint $complaint)
    {
        // Ensure the complaint is assigned to the current user
        $this->authorizeComplaintAccess($complaint);

        return view('staff.complaints.show', compact('complaint'));
    }

    /**
     * Show the form for editing the specified complaint.
     */
    public function edit(Complaint $complaint)
    {
        // Ensure the complaint is assigned to the current user
        $this->authorizeComplaintAccess($complaint);

        $users = User::all();
        return view('staff.complaints.edit', compact('complaint', 'users'));
    }

    /**
     * Update the specified complaint in storage.
     */
    public function update(Request $request, Complaint $complaint)
    {
        // Ensure the complaint is assigned to the current user
        $this->authorizeComplaintAccess($complaint);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:2048',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,in_progress,resolved,rejected',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'status' => $request->status,
            'assigned_to' => $request->assigned_to ?? Auth::id(), // Keep current assignment if not changed
        ];

        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($complaint->attachment) {
                Storage::disk('public')->delete($complaint->attachment);
            }

            $attachmentPath = $request->file('attachment')->store('complaints', 'public');
            $data['attachment'] = $attachmentPath;
        }

        $complaint->update($data);

        return redirect()->route('staff.complaints.index')->with('success', 'Pengaduan berhasil diperbarui.');
    }

    /**
     * Remove the specified complaint from storage.
     */
    public function destroy(Complaint $complaint)
    {
        // Ensure the complaint is assigned to the current user
        $this->authorizeComplaintAccess($complaint);

        // Delete attachment if exists
        if ($complaint->attachment) {
            Storage::disk('public')->delete($complaint->attachment);
        }

        $complaint->delete();
        return redirect()->route('staff.complaints.index')->with('success', 'Pengaduan berhasil dihapus.');
    }

    /**
     * Authorize that the current user can access the complaint.
     */
    private function authorizeComplaintAccess(Complaint $complaint)
    {
        if ($complaint->assigned_to != Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access to this complaint');
        }
    }
}
