@extends('citizen.layout')

@section('title', 'Buat Pengaduan')

@section('content')
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-slate-600 mb-2">
            <a href="{{ route('citizen.complaints.index') }}" class="hover:text-slate-900">Pengaduan Saya</a>
            <span>/</span>
            <span class="text-slate-900">Buat Pengaduan</span>
        </div>
    </div>

    <!-- Form Card -->
    <div class="max-w-4xl">
        <div class="bg-white rounded-xl border border-slate-200 p-8">
            <form action="{{ route('citizen.complaints.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf

                <!-- Title Field -->
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 mb-2">Judul Pengaduan</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        placeholder="Contoh: Jalan rusak di Jl. Mawar"
                        class="block w-full px-4 py-2.5 bg-white border {{ $errors->has('title') ? 'border-red-300' : 'border-slate-300' }} rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description Field -->
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-2">Deskripsi Lengkap</label>
                    <textarea name="description" id="description" rows="6" required
                        placeholder="Jelaskan detail pengaduan Anda secara rinci..."
                        class="block w-full px-4 py-2.5 bg-white border {{ $errors->has('description') ? 'border-red-300' : 'border-slate-300' }} rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Attachment Field -->
                <div>
                    <label for="attachment" class="block text-sm font-medium text-slate-700 mb-2">Lampiran
                        (Opsional)</label>
                    <input type="file" name="attachment" id="attachment"
                        class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="mt-1 text-xs text-slate-500">Format yang didukung: jpeg, png, jpg, pdf, doc, docx. Maksimal
                        2MB.</p>
                    @error('attachment')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 pt-4 border-t border-slate-200">
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        Kirim Pengaduan
                    </button>
                    <a href="{{ route('citizen.complaints.index') }}"
                        class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection