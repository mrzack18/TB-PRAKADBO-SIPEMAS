<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CitizenComplaintController extends Controller
{
    /**
     * Display a listing of the complaints for the authenticated citizen.
     */
    public function index()
    {
        $user = Auth::user();
        $complaints = Complaint::where('user_id', $user->id)
            ->with(['user', 'assignedUser'])
            ->latest()
            ->get();

        return view('citizen.complaints.index', compact('complaints'));
    }

    /**
     * Show the form for creating a new complaint.
     */
    public function create()
    {
        return view('citizen.complaints.create');
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
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'status' => 'pending', // Default status for new complaints
        ];

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('complaints', 'public');
            $data['attachment'] = $attachmentPath;
        }

        Complaint::create($data);

        return redirect()->route('citizen.complaints.index')->with('success', 'Pengaduan berhasil dikirim.');
    }

    /**
     * Display the specified complaint.
     */
    public function show(Complaint $complaint)
    {
        // Ensure the complaint belongs to the current user
        $this->authorizeComplaintAccess($complaint);

        return view('citizen.complaints.show', compact('complaint'));
    }

    /**
     * Show the form for editing the specified complaint.
     */
    public function edit(Complaint $complaint)
    {
        // Ensure the complaint belongs to the current user
        $this->authorizeComplaintAccess($complaint);

        return view('citizen.complaints.edit', compact('complaint'));
    }

    /**
     * Update the specified complaint in storage.
     */
    public function update(Request $request, Complaint $complaint)
    {
        // Ensure the complaint belongs to the current user
        $this->authorizeComplaintAccess($complaint);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
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

        return redirect()->route('citizen.complaints.index')->with('success', 'Pengaduan berhasil diperbarui.');
    }

    /**
     * Remove the specified complaint from storage.
     */
    public function destroy(Complaint $complaint)
    {
        // Ensure the complaint belongs to the current user
        $this->authorizeComplaintAccess($complaint);

        // Delete attachment if exists
        if ($complaint->attachment) {
            Storage::disk('public')->delete($complaint->attachment);
        }

        $complaint->delete();
        return redirect()->route('citizen.complaints.index')->with('success', 'Pengaduan berhasil dihapus.');
    }

    /**
     * Authorize that the current user can access the complaint.
     */
    private function authorizeComplaintAccess(Complaint $complaint)
    {
        if ($complaint->user_id != Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access to this complaint');
        }
    }
}
