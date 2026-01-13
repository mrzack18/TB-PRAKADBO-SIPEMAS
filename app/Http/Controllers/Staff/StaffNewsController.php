<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StaffNewsController extends Controller
{
    /**
     * Display a listing of the news created by the staff member.
     */
    public function index()
    {
        $user = Auth::user();
        $news = News::where('user_id', $user->id)
            ->with('user')
            ->latest()
            ->get();

        return view('staff.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new news.
     */
    public function create()
    {
        return view('staff.news.create');
    }

    /**
     * Store a newly created news in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published,archived',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
            'user_id' => Auth::id(),
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
            $data['image'] = $imagePath;
        }

        News::create($data);

        return redirect()->route('staff.news.index')->with('success', 'Berita berhasil dibuat.');
    }

    /**
     * Display the specified news.
     */
    public function show(News $news)
    {
        // Ensure the news belongs to the current user
        $this->authorizeNewsAccess($news);

        $news->load('comments.user', 'comments.replies.user');

        return view('staff.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified news.
     */
    public function edit(News $news)
    {
        // Ensure the news belongs to the current user
        $this->authorizeNewsAccess($news);

        return view('staff.news.edit', compact('news'));
    }

    /**
     * Update the specified news in storage.
     */
    public function update(Request $request, News $news)
    {
        // Ensure the news belongs to the current user
        $this->authorizeNewsAccess($news);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published,archived',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }

            $imagePath = $request->file('image')->store('news', 'public');
            $data['image'] = $imagePath;
        }

        $news->update($data);

        return redirect()->route('staff.news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified news from storage.
     */
    public function destroy(News $news)
    {
        // Ensure the news belongs to the current user
        $this->authorizeNewsAccess($news);

        // Delete image if exists
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();
        return redirect()->route('staff.news.index')->with('success', 'Berita berhasil dihapus.');
    }

    /**
     * Authorize that the current user can access the news.
     */
    private function authorizeNewsAccess(News $news)
    {
        if ($news->user_id != Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized access to this news');
        }
    }
}
