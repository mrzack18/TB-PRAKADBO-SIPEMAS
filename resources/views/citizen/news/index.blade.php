@extends('citizen.layout')

@section('title', 'Berita Desa')

@section('content')
    <!-- Header Section -->
    <div class="mb-6">
        <div class="md:flex md:items-center md:justify-between">
            <div>
                <h3 class="text-2xl font-bold text-slate-900">Berita Desa</h3>
                <p class="text-slate-600 mt-1">Informasi terbaru seputar kegiatan dan pengumuman desa</p>
            </div>
        </div>
    </div>

    <!-- News Grid -->
    @if($news->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($news as $item)
                <article
                    class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-md transition-shadow flex flex-col h-full">
                    @if($item->image)
                        <div class="aspect-video w-full overflow-hidden bg-slate-100">
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}"
                                class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="aspect-video w-full bg-slate-100 flex items-center justify-center text-slate-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif

                    <div class="p-5 flex-1 flex flex-col">
                        <div class="mb-3 flex items-center text-xs text-slate-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $item->created_at->format('d M Y') }}
                            <span class="mx-2">•</span>
                            <span>{{ $item->user->name }}</span>
                        </div>

                        <h4 class="text-lg font-bold text-slate-900 mb-2 line-clamp-2">
                            <a href="{{ route('citizen.news.show', $item) }}" class="hover:text-blue-600 transition-colors">
                                {{ $item->title }}
                            </a>
                        </h4>

                        <p class="text-slate-600 text-sm mb-4 line-clamp-3 flex-1">
                            {{ Str::limit(strip_tags($item->content), 120) }}
                        </p>

                        <div class="mt-auto pt-4 border-t border-slate-100">
                            <a href="{{ route('citizen.news.show', $item) }}"
                                class="text-blue-600 hover:text-blue-700 font-medium text-sm inline-flex items-center">
                                Baca Selengkapnya
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Pagination -->
        @if(method_exists($news, 'links'))
            <div class="mt-8">
                {{ $news->links() }}
            </div>
        @endif

    @else
        <div class="bg-white rounded-xl border border-slate-200 p-12 text-center">
            <div class="flex flex-col items-center justify-center">
                <svg class="w-16 h-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <h3 class="text-lg font-medium text-slate-900">Belum ada berita</h3>
                <p class="text-slate-500 mt-1">Saat ini belum ada informasi atau berita yang diterbitkan.</p>
            </div>
        </div>
    @endif
@endsection