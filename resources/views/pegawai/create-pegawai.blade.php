@extends('layouts.app')
@extends('layouts.navigation')
@extends('layouts.favicon')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section -->
    <h1 class="text-2xl font-bold mb-4">Tambah Pegawai</h1>

    <!-- Success Message -->
    @if (session('success'))
    <div class="bg-green-500 text-white p-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <!-- Error Messages -->
    @if ($errors->any())
    <div class="bg-red-500 text-white p-3 rounded mb-4">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form Tambah Pegawai -->
    <form method="POST" action="{{ route('pegawai.create') }}" class="space-y-4">
        @csrf
        <div class="space-y-2">
            <label for="name" class="block font-medium">Nama Pegawai</label>
            <input
                type="text"
                name="name"
                id="name"
                class="w-full border rounded px-4 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                value="{{ old('name') }}"
                required>
        </div>

        <div class="space-y-2">
            <label for="nip" class="block font-medium">NIP</label>
            <input
                type="text"
                name="nip"
                id="nip"
                class="w-full border rounded px-4 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                value="{{ old('nip') }}"
                required>
        </div>

        <div class="space-y-2">
            <label for="bidang_id" class="block font-medium">Bidang</label>
            <select
                name="bidang_id"
                id="bidang_id"
                class="w-full border rounded px-4 py-2 focus:outline-none focus:ring focus:ring-blue-300"
                required>
                <option value="" disabled selected>Pilih Bidang</option>
                @foreach ($bidangs as $bidang)
                <option value="{{ $bidang->id }}">{{ $bidang->name }}</option>
                @endforeach
            </select>
        </div>

        <button
            type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">
            Tambah Pegawai
        </button>
    </form>

    <!-- Tabel Daftar Pegawai -->
    <h2 class="text-xl font-bold mt-8 mb-4">Daftar Pegawai</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border rounded">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-4 py-2 text-left">ID</th>
                    <th class="border px-4 py-2 text-left">Nama</th>
                    <th class="border px-4 py-2 text-left">NIP</th>
                    <th class="border px-4 py-2 text-left">Bidang</th>
                    <th class="border px-4 py-2 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pegawai as $index => $p)
                <tr class="hover:bg-gray-100">
                    <td class="border px-4 py-2">{{ $index + 1 }}</td>
                    <td class="border px-4 py-2">{{ $p->name }}</td>
                    <td class="border px-4 py-2">{{ $p->nip }}</td>
                    <td class="border px-4 py-2">{{ $p->bidang->name ?? 'N/A' }}</td>
                    <td class="border px-4 py-2">
                        <span class="{{ $p->is_verified ? 'text-green-500' : 'text-red-500' }}">
                            {{ $p->is_verified ? 'Terverifikasi' : 'Belum Terverifikasi' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="border px-4 py-2 text-center" colspan="5">Belum ada data pegawai.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection