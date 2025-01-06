@extends('layouts.app')
@extends('layouts.navigation')
@extends('layouts.favicon')

@section('content')
<div class="container mx-auto max-w-lg px-6 py-8 bg-white shadow-md rounded-lg">
    <!-- Header -->
    <h1 class="text-3xl font-bold text-gray-800 text-center mb-6">Validasi NIP</h1>

    <!-- Success Message -->
    @if (session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
        <p class="font-medium">{{ session('success') }}</p>
    </div>
    @endif

    <!-- Error Messages -->
    @if ($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
        <ul class="list-disc pl-6">
            @foreach ($errors->all() as $error)
            <li class="font-medium">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form -->
    <form method="POST" action="{{ route('pegawai.validate-nip') }}" class="space-y-6">
        @csrf
        <div>
            <label for="nip" class="block text-lg font-medium text-gray-700 mb-2">NIP</label>
            <input
                type="text"
                name="nip"
                id="nip"
                class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                value="{{ old('nip') }}"
                placeholder="Masukkan NIP Anda"
                required>
        </div>
        <div class="flex justify-center">
            <button
                type="submit"
                class="w-full bg-blue-500 text-white text-lg font-semibold py-3 rounded-lg hover:bg-blue-600 transition duration-300 shadow-md">
                Validasi
            </button>
        </div>
    </form>
</div>
@endsection