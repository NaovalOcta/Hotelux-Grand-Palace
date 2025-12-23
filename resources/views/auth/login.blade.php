@extends('layouts.app')

@section('title', 'Login - Hotelux')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-900 py-20 px-4">
        <div class="max-w-md w-full bg-gray-800 rounded-2xl shadow-2xl border border-gray-700 overflow-hidden relative">
            {{-- Dekorasi --}}
            <div
                class="absolute top-0 right-0 w-32 h-32 bg-amber-600/10 rounded-full blur-2xl translate-x-1/2 -translate-y-1/2">
            </div>

            <div class="p-8 md:p-10 relative z-10">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-white mb-2">Welcome Back</h2>
                    <p class="text-gray-400">Sign in to manage your bookings</p>
                </div>

                @if (session('success'))
                    <div
                        class="bg-green-500/10 text-green-500 p-3 rounded mb-4 text-sm text-center border border-green-500/20">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Email Address</label>
                        <input type="email" name="email" required
                            class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:ring-2 focus:ring-amber-500 focus:border-transparent outline-none transition">
                        @error('email')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-1">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="login_password" required
                                class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 pr-10 focus:ring-2 focus:ring-amber-500 outline-none transition">

                            <button type="button" onclick="togglePassword('login_password', 'login_eye_icon')"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-white focus:outline-none">
                                <span id="login_eye_icon" class="material-icons-outlined text-xl">visibility</span>
                            </button>
                        </div>
                        @error('password')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 rounded-lg transition duration-300 shadow-lg">
                        Sign In
                    </button>
                </form>

                <div class="mt-8 text-center text-sm text-gray-400">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-amber-500 hover:text-amber-400 font-semibold">Register
                        here</a>
                </div>
            </div>
        </div>
    </div>
@endsection
