@extends('admin.layout')

@section('title', 'Detail User')

@section('content')
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-slate-600 mb-2">
            <a href="{{ route('admin.users.index') }}" class="hover:text-slate-900">Kelola Users</a>
            <span>/</span>
            <span class="text-slate-900">Detail User</span>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
            <!-- Header -->
            <div class="px-8 py-6 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">Informasi User</h3>
            </div>

            <!-- Content -->
            <div class="px-8 py-6 space-y-4">
                <div class="grid grid-cols-2 gap-x-6 gap-y-4">
                    <!-- Name -->
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Nama</p>
                        <p class="text-base text-slate-900">{{ $user->name }}</p>
                    </div>

                    <!-- Email -->
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Email</p>
                        <p class="text-base text-slate-900">{{ $user->email }}</p>
                    </div>

                    <!-- Role -->
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Role</p>
                        <span
                            class="inline-flex px-2 py-1 text-xs font-medium rounded-md
                            {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' :
        ($user->role === 'staf_desa' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700') }}">
                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                        </span>
                    </div>

                    <!-- Created At -->
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">Dibuat Pada</p>
                        <p class="text-base text-slate-900">{{ $user->created_at->format('d M Y H:i') }}</p>
                    </div>

                    <!-- Updated At -->
                    <div class="col-span-2">
                        <p class="text-sm font-medium text-slate-500 mb-1">Terakhir Diupdate</p>
                        <p class="text-base text-slate-900">{{ $user->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="px-8 py-6 bg-slate-50 border-t border-slate-200 flex gap-3">
                <a href="{{ route('admin.users.index') }}"
                    class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors">
                    Kembali
                </a>
                <a href="{{ route('admin.users.edit', $user) }}"
                    class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    Edit
                </a>
            </div>
        </div>
    </div>
@endsection