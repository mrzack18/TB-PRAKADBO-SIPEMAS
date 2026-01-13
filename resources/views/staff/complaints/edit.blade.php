@extends('staff.layout')

@section('title', 'Edit Pengaduan')

@section('content')
<!-- Header Section -->
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-slate-600 mb-2">
        <a href="{{ route('staff.complaints.index') }}" class="hover:text-slate-900">Kelola Pengaduan</a>
        <span>/</span>
        <span class="text-slate-900">Edit Pengaduan</span>
    </div>
</div>

<!-- Form Card -->
<div class="max-w-4xl">
    <div class="bg-white rounded-xl border border-slate-200 p-8">
        <form action="{{ route('staff.complaints.update', $complaint) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Title Field -->
            <div>
                <label for="title" class="block text-sm font-medium text-slate-700 mb-2">Judul</label>
                <input type="text" 
                    name="title" 
                    id="title" 
                    value="{{ old('title', $complaint->title) }}" 
                    required
                    class="block w-full px-4 py-2.5 bg-white border {{ $errors->has('title') ? 'border-red-300' : 'border-slate-300' }} rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Description Field -->
            <div>
                <label for="description" class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="5" 
                    required
                    class="block w-full px-4 py-2.5 bg-white border {{ $errors->has('description') ? 'border-red-300' : 'border-slate-300' }} rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">{{ old('description', $complaint->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- User/Pelapor Field -->
                <div>
                    <label for="user_id" class="block text-sm font-medium text-slate-700 mb-2">Pelapor</label>
                    <select name="user_id" 
                        id="user_id" 
                        required
                        class="block w-full px-4 py-2.5 bg-white border {{ $errors->has('user_id') ? 'border-red-300' : 'border-slate-300' }} rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Pilih Pelapor</option>
                        @foreach($users as $user)
                            @if($user->role !== 'staf_desa')
                                <option value="{{ $user->id }}" {{ old('user_id', $complaint->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Status Field -->
                <div>
                    <label for="status" class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                    <select name="status" 
                        id="status" 
                        required
                        class="block w-full px-4 py-2.5 bg-white border {{ $errors->has('status') ? 'border-red-300' : 'border-slate-300' }} rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Pilih Status</option>
                        <option value="pending" {{ old('status', $complaint->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ old('status', $complaint->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="resolved" {{ old('status', $complaint->status) == 'resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="rejected" {{ old('status', $complaint->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Attachment Field -->
            <div>
                <label for="attachment" class="block text-sm font-medium text-slate-700 mb-2">Lampiran</label>
                <input type="file" 
                    name="attachment" 
                    id="attachment"
                    class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="mt-1 text-xs text-slate-500">Format: jpeg, png, jpg, pdf, doc, docx. Maksimal 2MB. Kosongkan jika tidak ingin diubah.</p>
                
                @if($complaint->attachment)
                    <div class="mt-3 flex items-center p-3 bg-slate-50 rounded-lg border border-slate-200">
                        <svg class="w-5 h-5 text-slate-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                        <span class="text-sm text-slate-600 truncate mr-3 flex-1">Lampiran saat ini</span>
                        <a href="{{ asset('storage/' . $complaint->attachment) }}" target="_blank" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline">
                            Lihat
                        </a>
                    </div>
                @endif
                
                @error('attachment')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Action Buttons -->
            <div class="flex gap-3 pt-4 border-t border-slate-200">
                <button type="submit" 
                    class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    Update
                </button>
                <a href="{{ route('staff.complaints.index') }}" 
                    class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection