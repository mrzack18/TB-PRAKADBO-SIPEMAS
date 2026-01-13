@extends('admin.layout')

@section('title', 'Edit User')

@section('content')
    <!-- Header Section -->
    <div class="mb-6">
        <div class="flex items-center gap-2 text-sm text-slate-600 mb-2">
            <a href="{{ route('admin.users.index') }}" class="hover:text-slate-900">Kelola Users</a>
            <span>/</span>
            <span class="text-slate-900">Edit User</span>
        </div>
    </div>

    <!-- Form Card -->
    <div class="max-w-2xl">
        <div class="bg-white rounded-xl border border-slate-200 p-8">
            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-2">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                        class="block w-full px-4 py-2.5 bg-white border {{ $errors->has('name') ? 'border-red-300' : 'border-slate-300' }} rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                        class="block w-full px-4 py-2.5 bg-white border {{ $errors->has('email') ? 'border-red-300' : 'border-slate-300' }} rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role Field -->
                <div>
                    <label for="role" class="block text-sm font-medium text-slate-700 mb-2">Role</label>
                    <select name="role" id="role" required
                        class="block w-full px-4 py-2.5 bg-white border {{ $errors->has('role') ? 'border-red-300' : 'border-slate-300' }} rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Pilih Role</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="staf_desa" {{ old('role', $user->role) == 'staf_desa' ? 'selected' : '' }}>Staf Desa
                        </option>
                        <option value="perwakilan_masyarakat" {{ old('role', $user->role) == 'perwakilan_masyarakat' ? 'selected' : '' }}>Perwakilan Masyarakat</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                    <p class="text-xs text-slate-500 mb-2">Kosongkan jika tidak ingin mengubah password</p>
                    <input type="password" name="password" id="password"
                        class="block w-full px-4 py-2.5 bg-white border {{ $errors->has('password') ? 'border-red-300' : 'border-slate-300' }} rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Confirmation Field -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi
                        Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="block w-full px-4 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 pt-4 border-t border-slate-200">
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        Update
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                        class="px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection