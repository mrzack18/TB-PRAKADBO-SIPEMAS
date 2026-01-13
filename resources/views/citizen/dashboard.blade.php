@extends('citizen.layout')

@section('title', 'Dashboard')

@section('content')
    <!-- Welcome Section -->
    <div class="mb-8">
        <h3 class="text-lg font-semibold text-slate-900 mb-1">Selamat Datang, {{ Auth::user()->name }}</h3>
        <p class="text-slate-600">Pantau dan ajukan pengaduan Anda di sini.</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Pengaduan -->
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600 mb-1">Total Pengaduan</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $totalComplaints }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600 mb-1">Pending</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $pendingComplaints }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Dalam Proses -->
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600 mb-1">Dalam Proses</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $inProgressComplaints }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Selesai -->
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600 mb-1">Selesai</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $resolvedComplaints }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mb-8">
        <div class="bg-white rounded-xl border border-slate-200 p-8">
            <h4 class="text-lg font-semibold text-slate-900 mb-4">Akses Cepat</h4>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('citizen.complaints.create') }}"
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Buat Pengaduan
                </a>
                <a href="{{ route('citizen.complaints.index') }}"
                    class="px-6 py-3 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-medium rounded-lg transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Lihat Pengaduan
                </a>
                <a href="{{ route('citizen.news.index') }}"
                    class="px-6 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 hover:bg-emerald-100 font-medium rounded-lg transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    Berita Terbaru
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Complaints -->
        <div>
            <div class="bg-white rounded-xl border border-slate-200 p-6 h-full">
                <h4 class="text-lg font-semibold text-slate-900 mb-4">Pengaduan Terbaru Anda</h4>
                @if($recentComplaints->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentComplaints as $complaint)
                                <a href="{{ route('citizen.complaints.show', $complaint) }}"
                                    class="block p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors border border-slate-100">
                                    <div class="flex justify-between items-start mb-2">
                                        <h5 class="font-medium text-slate-900 line-clamp-1">{{ $complaint->title }}</h5>
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-medium rounded-md
                                                    {{ $complaint->status === 'pending' ? 'bg-amber-100 text-amber-700' :
                            ($complaint->status === 'in_progress' ? 'bg-blue-100 text-blue-700' :
                                ($complaint->status === 'resolved' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-500">{{ $complaint->created_at->diffForHumans() }}</p>
                                </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-slate-500">Belum ada pengaduan yang diajukan.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Latest News -->
        <div>
            <div class="bg-white rounded-xl border border-slate-200 p-6 h-full">
                <h4 class="text-lg font-semibold text-slate-900 mb-4">Berita Desa Terbaru</h4>
                @if($publishedNews->count() > 0)
                    <div class="space-y-4">
                        @foreach($publishedNews as $news)
                            <a href="{{ route('citizen.news.show', $news) }}"
                                class="block p-4 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors border border-slate-100">
                                <h5 class="font-medium text-slate-900 line-clamp-1 mb-1">{{ $news->title }}</h5>
                                <div class="flex items-center text-xs text-slate-500">
                                    <span class="mr-2">{{ $news->created_at->diffForHumans() }}</span>
                                    <span>•</span>
                                    <span class="ml-2">oleh {{ $news->user->name }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-slate-500">Belum ada berita terbaru.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection