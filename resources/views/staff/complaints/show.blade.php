@extends('staff.layout')

@section('title', 'Detail Pengaduan')

@section('content')
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-slate-600 mb-2">
            <a href="{{ route('staff.complaints.index') }}" class="hover:text-slate-900">Kelola Pengaduan</a>
            <span>/</span>
            <span class="text-slate-900">Detail Pengaduan</span>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="max-w-4xl">
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <!-- Header -->
            <div class="px-8 py-6 border-b border-slate-200">
                <h3 class="text-2xl font-bold text-slate-900">{{ $complaint->title }}</h3>
            </div>

            <!-- Content -->
            <div class="px-8 py-6">
                <!-- Meta Information -->
                <div class="grid grid-cols-2 gap-x-6 gap-y-4 mb-6 pb-6 border-b border-slate-200">
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Pelapor</p>
                        <p class="text-base text-slate-900">{{ $complaint->user->name }}</p>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Status</p>
                        <span
                            class="inline-flex px-2 py-1 text-xs font-medium rounded-md
                            {{ $complaint->status === 'pending' ? 'bg-amber-100 text-amber-700' :
        ($complaint->status === 'in_progress' ? 'bg-blue-100 text-blue-700' :
            ($complaint->status === 'resolved' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700')) }}">
                            {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                        </span>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Ditugaskan Kepada</p>
                        @if($complaint->assignedUser)
                            <p class="text-base text-slate-900">{{ $complaint->assignedUser->name }}</p>
                        @else
                            <p class="text-base text-slate-400 italic">Belum ditugaskan</p>
                        @endif
                    </div>

                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Dibuat Pada</p>
                        <p class="text-base text-slate-900">{{ $complaint->created_at->format('d M Y H:i') }}</p>
                    </div>

                    @if($complaint->resolved_at)
                        <div>
                            <p class="text-sm font-medium text-slate-500 mb-1">Selesai Pada</p>
                            <p class="text-base text-slate-900">{{ $complaint->resolved_at->format('d M Y H:i') }}</p>
                        </div>
                    @endif
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-slate-900 mb-3">Deskripsi</h4>
                    <div class="prose max-w-none p-4 bg-slate-50 rounded-lg border border-slate-200 text-slate-700">
                        {!! nl2br(e($complaint->description)) !!}
                    </div>
                </div>

                <!-- Attachment -->
                @if($complaint->attachment)
                    <div>
                        <h4 class="text-lg font-semibold text-slate-900 mb-3">Lampiran</h4>
                        <div class="flex items-center p-4 bg-slate-50 rounded-lg border border-slate-200">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-slate-900">Berkas Lampiran</p>
                                <p class="text-xs text-slate-500">Klik tombol di kanan untuk mengunduh</p>
                            </div>
                            <a href="{{ asset('storage/' . $complaint->attachment) }}" target="_blank"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Unduh
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Footer Actions -->
            <div class="px-8 py-6 bg-slate-50 border-t border-slate-200 flex gap-3">
                <a href="{{ route('staff.complaints.index') }}"
                    class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors">
                    Kembali
                </a>
                <a href="{{ route('staff.complaints.edit', $complaint) }}"
                    class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition-colors">
                    Edit
                </a>
            </div>
        </div>
    </div>
@endsection