<x-guest-layout>
    @extends('layouts.favicon')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <div>
        <div class="w-full max-w-lg px-8 py-6 bg-white shadow-lg rounded-lg">
            <h2 class="text-2xl font-bold text-center text-gray-800">{{ __('Buat Akun Anda') }}</h2>
            <p class="text-sm text-center text-gray-600 mt-2">
                {{ __('Daftar untuk mulai masuk.') }}
            </p>

            <form method="POST" action="{{ route('register') }}" class="mt-6">
                @csrf

                <!-- Nama -->
                <div class="mb-4">
                    <x-input-label for="name" :value="__('Nama Lengkap')" />
                    <x-text-input id="name" class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Alamat Email -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Bidang -->
                <div class="mb-4">
                    <x-input-label for="bidang_id" :value="__('Bidang')" />
                    <select id="bidang_id" name="bidang_id" class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="" disabled selected>-- Pilih Bidang --</option>
                        @foreach ($bidangs as $bidang)
                        <option value="{{ $bidang->id }}">{{ $bidang->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('bidang_id')" class="mt-2" />
                </div>

                <!-- Kata Sandi -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Kata Sandi')" />
                    <x-text-input id="password" class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Konfirmasi Kata Sandi -->
                <div class="mb-4">
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />
                    <x-text-input id="password_confirmation" class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Tombol -->
                <div class="flex items-center justify-between mt-6">
                    <a class="text-sm text-gray-600 hover:text-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                        {{ __('Kembali ke halaman Login?') }}
                    </a>
                    <x-primary-button class="px-6 py-2">
                        {{ __('Daftar') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>