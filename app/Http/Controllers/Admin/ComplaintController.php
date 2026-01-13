<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the complaints.
     */
    public function index()
    {
        $complaints = Complaint::with(['user', 'assignedUser'])->latest()->get();
        return view('admin.complaints.index', compact('complaints'));
    }

    /**
     * Show the form for creating a new complaint.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.complaints.create', compact('users'));
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
            'status' => 'required|in:pending,in_progress,resolved,rejected',
            'user_id' => 'required|exists:users,id',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'user_id' => $request->user_id,
        ];

        if ($request->has('assigned_to') && $request->assigned_to !== '') {
            $data['assigned_to'] = $request->assigned_to;
        }

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('complaints', 'public');
            $data['attachment'] = $attachmentPath;
        }

        Complaint::create($data);

        return redirect()->route('admin.complaints.index')->with('success', 'Complaint created successfully.');
    }

    /**
     * Display the specified complaint.
     */
    public function show(Complaint $complaint)
    {
        return view('admin.complaints.show', compact('complaint'));
    }

    /**
     * Show the form for editing the specified complaint.
     */
    public function edit(Complaint $complaint)
    {
        $users = User::all();
        return view('admin.complaints.edit', compact('complaint', 'users'));
    }

    /**
     * Update the specified complaint in storage.
     */
    public function update(Request $request, Complaint $complaint)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:2048',
            'status' => 'required|in:pending,in_progress,resolved,rejected',
            'user_id' => 'required|exists:users,id',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'user_id' => $request->user_id,
        ];

        if ($request->has('assigned_to') && $request->assigned_to !== '') {
            $data['assigned_to'] = $request->assigned_to;
        } else {
            $data['assigned_to'] = null;
        }

        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($complaint->attachment) {
                Storage::disk('public')->delete($complaint->attachment);
            }

            $attachmentPath = $request->file('attachment')->store('complaints', 'public');
            $data['attachment'] = $attachmentPath;
        }

        $complaint->update($data);

        return redirect()->route('admin.complaints.index')->with('success', 'Complaint updated successfully.');
    }

    /**
     * Remove the specified complaint from storage.
     */
    public function destroy(Complaint $complaint)
    {
        // Delete attachment if exists
        if ($complaint->attachment) {
            Storage::disk('public')->delete($complaint->attachment);
        }

        $complaint->delete();
        return redirect()->route('admin.complaints.index')->with('success', 'Complaint deleted successfully.');
    }
}
