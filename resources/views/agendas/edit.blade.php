@extends('layouts.app')
@extends('layouts.navigation')
@extends('layouts.favicon')

@section('content')
@include('components.popup')
<div class="container mx-auto px-4 py-8">

    <!-- Header -->
    <h1 class="text-4xl font-bold text-gray-900 border-b-2 border-gray-300 pb-4 mb-6">
        Update Agenda Kegiatan
    </h1>

    <!-- Pesan Flash -->
    @if (session('success'))
    <div class="flex items-center bg-green-100 border border-green-300 text-green-800 text-sm rounded-lg px-4 py-3 mb-6 shadow-md">
        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m4 4a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <!-- Pesan Error -->
    @if ($errors->any())
    <div class="bg-red-100 border border-red-300 text-red-800 rounded-lg px-4 py-3 mb-6 shadow-md">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Formulir Update Agenda -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Update Agenda Kegiatan</h2>
        <form action="{{ route('agendas.update', $agenda->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nama_acara" class="block text-sm font-medium text-gray-700">Nama Acara</label>
                    <input type="text" id="nama_acara" name="nama_acara" value="{{ old('nama_acara', $agenda->nama_acara) }}" placeholder="Masukkan nama acara" class="input-field">
                </div>

                <div>
                    <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select id="kategori" name="kategori" class="input-field">
                        <option value="Biasa" {{ $agenda->kategori == 'Biasa' ? 'selected' : '' }}>Biasa</option>
                        <option value="Penting" {{ $agenda->kategori == 'Penting' ? 'selected' : '' }}>Penting</option>
                    </select>
                </div>

                <div>
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $agenda->tanggal_mulai) }}" class="input-field">
                </div>

                <div>
                    <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                    <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $agenda->tanggal_selesai) }}" class="input-field">
                </div>

                <div>
                    <label for="waktu_mulai" class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
                    <input type="time" id="waktu_mulai" name="waktu_mulai" value="{{ old('waktu_mulai', $agenda->waktu_mulai) }}" class="input-field">
                </div>

                <div>
                    <label for="waktu_selesai" class="block text-sm font-medium text-gray-700">Waktu Selesai</label>
                    <input type="time" id="waktu_selesai" name="waktu_selesai" value="{{ old('waktu_selesai', $agenda->waktu_selesai) }}" class="input-field">
                </div>

                <div class="md:col-span-2">
                    <label for="tempat" class="block text-sm font-medium text-gray-700">Tempat</label>
                    <input type="text" id="tempat" name="tempat" value="{{ old('tempat', $agenda->tempat) }}" placeholder="Masukkan tempat acara" class="input-field">
                </div>

                <div class="md:col-span-2">
                    <label for="list_daftar_nama" class="block text-sm font-medium text-gray-700">Daftar Nama Peserta</label>
                    <button type="button" class="btn-popup bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600" onclick="openPopup()">Pilih Peserta</button>
                </div>

                <!-- Popup Form -->
                <div id="popupForm" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
                    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg">
                        <div class="flex justify-between items-center mb-4 border-b pb-2">
                            <h2 class="text-xl font-semibold text-gray-800">Pilih Peserta</h2>
                            <button type="button" class="text-gray-600 hover:text-gray-900 text-2xl" onclick="closePopup()">&times;</button>
                        </div>
                        <input type="text" id="search_list_daftar_nama" class="w-full border border-gray-300 rounded py-2 px-3 mb-2" placeholder="Cari nama peserta..." oninput="filterOptions()">
                        <div id="list_daftar_nama" class="space-y-2 max-h-40 overflow-y-auto border border-gray-300 rounded p-2">
                            @foreach ($pegawai as $item)
                            <div class="flex items-center py-1 px-2 hover:bg-gray-100 rounded">
                                <input type="checkbox" name="list_daftar_nama[]" value="{{ $item->id }}" id="pegawai_{{ $item->id }}" class="checkbox">
                                <label for="pegawai_{{ $item->id }}" class="ml-2 text-gray-700">{{ $item->name }} - {{ $item->bidang->name }}</label>
                            </div>
                            @endforeach
                        </div>
                        <div class="flex justify-end mt-4">
                            <button type="button" class="bg-gray-400 text-white py-2 px-4 rounded hover:bg-gray-500" onclick="closePopup()">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit mt-6">Update Agenda</button>
        </form>
    </div>

</div>

<script>
    function openPopup() {
        document.getElementById('popupForm').classList.remove('hidden');
    }

    function closePopup() {
        document.getElementById('popupForm').classList.add('hidden');
    }

    function filterOptions() {
        let searchInput = document.getElementById('search_list_daftar_nama').value.toLowerCase();
        let options = document.querySelectorAll('#list_daftar_nama .flex');

        options.forEach(option => {
            let label = option.querySelector('label').textContent.toLowerCase();
            if (label.indexOf(searchInput) > -1) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        });
    }

    function filterOptions() {
        let searchInput = document.getElementById('search_list_daftar_nama').value.toLowerCase();
        let options = document.querySelectorAll('#list_daftar_nama .flex');

        options.forEach(option => {
            let label = option.querySelector('label').textContent.toLowerCase();
            if (label.indexOf(searchInput) > -1) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        });
    }
</script>

@endsection