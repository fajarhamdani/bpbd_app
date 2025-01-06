<x-guest-layout>
    @extends('layouts.favicon')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <div>
        <div class="w-full max-w-md px-8 py-6 bg-white shadow-lg rounded-lg">
            <!-- Session Status -->
            <h2 class="text-2xl font-bold text-gray-800 text-center">{{ __('Login Ke Akun Anda') }}</h2>

            <form method="POST" action="{{ route('login') }}" class="mt-6">
                @csrf

                <!-- Alamat Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Kata Sandi -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Kata Sandi')" />
                    <x-text-input id="password" class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mt-4">
                    <label for="remember_me" class="inline-flex items-center text-gray-600">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" name="remember">
                        <span class="ml-2 text-sm">{{ __('Ingatkan saya') }}</span>
                    </label>
                </div>

                <!-- Tombol Login -->
                <div class="mt-6">
                    <x-primary-button class="w-full justify-center py-2">
                        {{ __('Masuk') }}
                    </x-primary-button>
                </div>
            </form>

            <!-- Link ke Halaman Daftar -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    {{ __("Belum punya akun?") }}
                    <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                        {{ __('Daftar disini') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>