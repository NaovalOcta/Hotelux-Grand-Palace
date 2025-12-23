@extends('layouts.app')

@section('title', 'Register - Hotelux')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-900 py-20 px-4">
        <div class="max-w-md w-full bg-gray-800 rounded-2xl shadow-2xl border border-gray-700 overflow-hidden relative">
            <div class="p-8 md:p-10 relative z-10">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-white mb-2">Create Account</h2>
                    <p class="text-gray-400">Join us for a luxurious experience</p>
                </div>

                <form action="{{ route('register') }}" method="POST" class="space-y-5">
                    @csrf
                    {{-- Name --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:ring-2 focus:ring-amber-500 outline-none">
                        @error('name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:ring-2 focus:ring-amber-500 outline-none">
                        @error('email')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required
                            class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:ring-2 focus:ring-amber-500 outline-none">
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="reg_password" required
                                class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 pr-10 focus:ring-2 focus:ring-amber-500 outline-none transition">

                            <button type="button" onclick="togglePassword('reg_password', 'reg_eye_icon')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-white focus:outline-none">
                                <span id="reg_eye_icon" class="material-icons-outlined text-xl">visibility</span>
                            </button>
                        </div>
                        @error('password')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Confirm Password</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="reg_confirm_password" required
                                class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 pr-10 focus:ring-2 focus:ring-amber-500 outline-none transition">

                            <button type="button" onclick="togglePassword('reg_confirm_password', 'reg_confirm_eye_icon')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-white focus:outline-none">
                                <span id="reg_confirm_eye_icon" class="material-icons-outlined text-xl">visibility</span>
                            </button>
                        </div>
                    </div>
                </form>

                <div class="mt-6 text-center text-sm text-gray-400">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-amber-500 hover:text-amber-400 font-semibold">Sign In</a>
                </div>
            </div>
        </div>
    </div>
@endsection
