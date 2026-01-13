@extends('citizen.layout')

@section('title', 'Detail Berita')

@section('content')
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-slate-600 mb-2">
            <a href="{{ route('citizen.news.index') }}" class="hover:text-slate-900">Berita Desa</a>
            <span>/</span>
            <span class="text-slate-900">Detail Berita</span>
        </div>
    </div>

    <div class="max-w-4xl mx-auto">
        <article class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <!-- Image -->
            @if($news->image)
                <div class="w-full h-64 md:h-96 bg-slate-100 relative">
                    <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}"
                        class="w-full h-full object-cover">
                </div>
            @endif

            <div class="p-8">
                <!-- Header -->
                <header class="mb-8">
                    <h1 class="text-3xl font-bold text-slate-900 mb-4 leading-tight">{{ $news->title }}</h1>

                    <div class="flex flex-wrap items-center gap-4 text-sm text-slate-600 border-b border-slate-100 pb-6">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>{{ $news->user->name }}</span>
                        </div>

                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ $news->created_at->translatedFormat('l, d F Y - H:i') }}</span>
                        </div>
                    </div>
                </header>

                <!-- Content -->
                <div
                    class="prose prose-slate max-w-none prose-img:rounded-xl prose-a:text-blue-600 hover:prose-a:text-blue-700">
                    {!! nl2br(e($news->content)) !!}
                </div>

                <!-- Comments Section -->
                <div class="mt-12 pt-8 border-t border-slate-200">
                    <div class="flex items-center justify-between mb-8">
                        <h4 class="text-xl font-bold text-slate-900">Komentar ({{ $news->comments->count() }})</h4>
                    </div>

                    <!-- Add Comment Form -->
                    <div class="bg-slate-50 rounded-xl p-6 mb-10 border border-slate-200">
                        <form action="{{ route('comments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="news_id" value="{{ $news->id }}">
                            <div class="mb-4">
                                <label for="content" class="block text-sm font-medium text-slate-700 mb-2">Tulis
                                    Komentar</label>
                                <textarea name="content" id="content" rows="3"
                                    class="w-full px-4 py-3 bg-white border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none placeholder-slate-400"
                                    placeholder="Bagikan pendapat Anda tentang berita ini..." required></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors shadow-sm flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                    Kirim Komentar
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Comments List -->
                    <div class="space-y-8">
                        @forelse($news->comments as $comment)
                            <!-- Comment Item -->
                            <div class="flex gap-4">
                                <!-- Avatar -->
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center border border-blue-200">
                                        <span
                                            class="text-blue-700 font-bold text-sm">{{ substr($comment->user->name, 0, 2) }}</span>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="flex-1">
                                    <div class="bg-white p-4 rounded-xl border border-slate-200 rounded-tl-none shadow-sm">
                                        <div class="flex items-center justify-between mb-2">
                                            <div>
                                                <h5 class="font-semibold text-slate-900">{{ $comment->user->name }}</h5>
                                                <div class="flex items-center text-xs text-slate-500">
                                                    <span>{{ $comment->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>

                                            @if(Auth::check() && (Auth::id() == $comment->user_id || Auth::user()->role === 'admin'))
                                                <form action="{{ route('comments.destroy', $comment) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-slate-400 hover:text-red-600 transition-colors"
                                                        title="Hapus Komentar" onclick="return confirm('Hapus komentar ini?')">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>

                                        <p class="text-slate-700 text-sm leading-relaxed">{{ $comment->content }}</p>
                                    </div>

                                    <!-- Actions -->
                                    <div class="mt-2 flex items-center gap-4 ml-2">
                                        <button onclick="toggleReplyForm({{ $comment->id }})"
                                            class="text-sm text-slate-500 hover:text-blue-600 font-medium flex items-center transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                            </svg>
                                            Balas
                                        </button>
                                    </div>

                                    <!-- Reply Form -->
                                    <div id="reply-form-{{ $comment->id }}" class="hidden mt-4 ml-2">
                                        <form action="{{ route('comments.store') }}" method="POST"
                                            class="flex gap-3 items-start">
                                            @csrf
                                            <input type="hidden" name="news_id" value="{{ $news->id }}">
                                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center border border-slate-200">
                                                    <span
                                                        class="text-slate-600 font-bold text-xs">{{ substr(Auth::user()->name, 0, 2) }}</span>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <textarea name="content" rows="1"
                                                    class="w-full px-3 py-2 bg-white border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm resize-none"
                                                    placeholder="Tulis balasan..." required></textarea>
                                            </div>
                                            <button type="submit"
                                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                                Kirim
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Replies List -->
                                    @if($comment->replies->count() > 0)
                                        <div class="mt-6 space-y-6 pl-4 border-l-2 border-slate-100 ml-4">
                                            @foreach($comment->replies as $reply)
                                                <div class="flex gap-3">
                                                    <div class="flex-shrink-0">
                                                        <div
                                                            class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center border border-slate-200">
                                                            <span
                                                                class="text-slate-600 font-bold text-xs">{{ substr($reply->user->name, 0, 2) }}</span>
                                                        </div>
                                                    </div>

                                                    <div class="flex-1">
                                                        <div class="bg-slate-50 p-3 rounded-lg border border-slate-200 rounded-tl-none">
                                                            <div class="flex items-center justify-between mb-1">
                                                                <div>
                                                                    <span
                                                                        class="font-semibold text-slate-900 text-sm">{{ $reply->user->name }}</span>
                                                                    <span
                                                                        class="text-xs text-slate-500 ml-2">{{ $reply->created_at->diffForHumans() }}</span>
                                                                </div>
                                                                @if(Auth::check() && (Auth::id() == $reply->user_id || Auth::user()->role === 'admin'))
                                                                    <form action="{{ route('comments.destroy', $reply) }}" method="POST"
                                                                        class="inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="text-slate-400 hover:text-red-600 transition-colors"
                                                                            title="Hapus Balasan"
                                                                            onclick="return confirm('Hapus balasan ini?')">
                                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                                                viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                            </svg>
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                            <p class="text-slate-700 text-sm">{{ $reply->content }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 bg-slate-50 rounded-xl border border-dashed border-slate-300">
                                <svg class="w-12 h-12 text-slate-400 mx-auto mb-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                                </svg>
                                <h3 class="text-lg font-medium text-slate-900">Belum ada komentar</h3>
                                <p class="text-slate-500 mt-1">Jadilah yang pertama untuk memberikan pendapat!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 pt-8 border-t border-slate-100 flex justify-between items-center">
                    <a href="{{ route('citizen.news.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition-colors font-medium text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Daftar Berita
                    </a>
                </div>
            </div>
        </article>
    </div>

    <script>
        function toggleReplyForm(commentId) {
            const form = document.getElementById('reply-form-' + commentId);
            form.classList.toggle('hidden');
        }
    </script>
@endsection