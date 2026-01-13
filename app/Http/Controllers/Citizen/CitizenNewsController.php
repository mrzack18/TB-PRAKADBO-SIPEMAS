<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;

class CitizenNewsController extends Controller
{
    /**
     * Display a listing of published news for citizens.
     */
    public function index()
    {
        $news = News::where('status', 'published')
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('citizen.news.index', compact('news'));
    }

    /**
     * Display the specified news.
     */
    public function show(News $news)
    {
        // Ensure the news is published
        if ($news->status !== 'published' && !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized access to this news');
        }

        $news->load('comments.user', 'comments.replies.user');

        return view('citizen.news.show', compact('news'));
    }
}
