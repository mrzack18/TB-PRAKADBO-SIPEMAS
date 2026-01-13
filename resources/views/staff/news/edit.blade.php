@extends('staff.layout')

@section('title', 'Edit Berita')

@section('content')
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-slate-600 mb-2">
            <a href="{{ route('staff.news.index') }}" class="hover:text-slate-900">Kelola Berita</a>
            <span>/</span>
            <span class="text-slate-900">Edit Berita</span>
        </div>
    </div>

    <!-- Form Card -->
    <div class="max-w-4xl">
        <div class="bg-white rounded-xl border border-slate-200 p-8">
            <form action="{{ route('staff.news.update', $news) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Title Field -->
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 mb-2">Judul</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $news->title) }}" required
                        class="block w-full px-4 py-2.5 bg-white border {{ $errors->has('title') ? 'border-red-300' : 'border-slate-300' }} rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content Field -->
                <div>
                    <label for="content" class="block text-sm font-medium text-slate-700 mb-2">Konten</label>
                    <textarea name="content" id="content" rows="10" required
                        class="block w-full px-4 py-2.5 bg-white border {{ $errors->has('content') ? 'border-red-300' : 'border-slate-300' }} rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">{{ old('content', $news->content) }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image Field -->
                <div>
                    <label for="image" class="block text-sm font-medium text-slate-700 mb-2">Gambar</label>
                    <input type="file" name="image" id="image"
                        class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="mt-1 text-xs text-slate-500">Format: jpeg, png, jpg, gif. Maksimal 2MB. Kosongkan jika tidak
                        ingin diubah.</p>
                    @if($news->image)
                        <div class="mt-3 p-3 bg-slate-50 rounded-lg border border-slate-200">
                            <p class="text-sm font-medium text-slate-700 mb-2">Gambar saat ini:</p>
                            <img src="{{ asset('storage/' . $news->image) }}" alt="Current Image"
                                class="rounded-lg border border-slate-200" style="max-height: 200px;">
                        </div>
                    @endif
                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status Field -->
                <div>
                    <label for="status" class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                    <select name="status" id="status" required
                        class="block w-full px-4 py-2.5 bg-white border {{ $errors->has('status') ? 'border-red-300' : 'border-slate-300' }} rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Pilih Status</option>
                        <option value="draft" {{ old('status', $news->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $news->status) == 'published' ? 'selected' : '' }}>
                            Published</option>
                        <option value="archived" {{ old('status', $news->status) == 'archived' ? 'selected' : '' }}>Archived
                        </option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 pt-4 border-t border-slate-200">
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        Update
                    </button>
                    <a href="{{ route('staff.news.index') }}"
                        class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection