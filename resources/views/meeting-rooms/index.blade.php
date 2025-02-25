@extends('layouts.app')
@extends('layouts.navigation')
@extends('layouts.favicon')

@section('content')
@include('components.popup')
<div class="container mx-auto px-4 py-8">

    <!-- Header -->
    <h1 class="text-4xl font-bold text-gray-900 border-b-2 border-gray-300 pb-4 mb-6">
        Buat Rapat
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

    <!-- Pesan Verifikasi untuk Role ID 3 -->
    @if (auth()->user()->role_id == 3)
    <div class="flex items-center bg-yellow-100 border border-yellow-300 text-yellow-800 text-sm rounded-lg px-4 py-3 mb-6 shadow-md">
        <i class='bx bx-info-circle bx-sm mr-3'></i>
        Anda perlu melakukan verifikasi terlebih dahulu.
    </div>
    @endif

    <!-- Formulir Buat Agenda -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Buat Rapat Baru</h2>
        <form action="{{ route('meeting-rooms.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nama_acara" class="block text-sm font-medium text-gray-700">Nama Acara</label>
                    <input type="text" id="nama_acara" name="nama_acara" placeholder="Masukkan nama acara" value="{{ old('nama_acara') }}" class="input-field">
                </div>

                <div>
                    <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select id="kategori" name="kategori" class="input-field">
                        <option value="">Pilih Kategori</option>
                        <option value="Rapat">Rapat</option>
                    </select>
                </div>

                <div>
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" class="input-field">
                </div>

                <div>
                    <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                    <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="input-field">
                </div>

                <div>
                    <label for="waktu_mulai" class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
                    <input type="time" id="waktu_mulai" name="waktu_mulai" value="{{ old('waktu_mulai') }}" class="input-field">
                </div>

                <div>
                    <label for="waktu_selesai" class="block text-sm font-medium text-gray-700">Waktu Selesai</label>
                    <input type="time" id="waktu_selesai" name="waktu_selesai" value="{{ old('waktu_selesai') }}" class="input-field">
                </div>

                <div class="md:col-span-2">
                    <label for="tempat" class="block text-sm font-medium text-gray-700">Tempat</label>
                    <input type="text" id="tempat" name="tempat" placeholder="Masukkan tempat acara" value="{{ old('tempat') }}" class="input-field">
                </div>

                <div class="md:col-span-2">
                    <label for="list_daftar_nama" class="block text-sm font-medium text-gray-700">Daftar Nama Peserta</label>
                    <button type="button" id="openModalButton" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-4 py-2 rounded-lg mt-2 transition duration-300">Pilih Peserta</button>
                    <div id="selectedParticipants" class="mt-2 space-y-2"></div>
                </div>

                <!-- Modal form popup -->
                <div id="participantModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
                    <div class="flex items-center justify-center min-h-screen">
                        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                            <div class="absolute inset-0 bg-gray-600 bg-opacity-50"></div>
                        </div>
                        <div class="bg-white rounded-lg shadow-xl transform transition-all sm:max-w-lg sm:w-full border-t-4 border-yellow-500">
                            <div class="bg-white px-6 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                        <h3 class="text-lg leading-6 font-semibold text-gray-900">Pilih Peserta</h3>
                                        <div class="mt-2">
                                            <input type="text" id="search_list_daftar_nama" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Cari nama peserta..." oninput="filterOptions()">
                                            <div id="list_daftar_nama" class="space-y-2 max-h-40 overflow-y-auto border border-gray-300 rounded-lg p-2 mt-2">
                                                @foreach ($pegawai as $item)
                                                <div class="flex items-center p-2 bg-gray-100 rounded-lg hover:bg-yellow-100 transition">
                                                    <input type="checkbox" name="list_daftar_nama[]" value="{{ $item->id }}" id="pegawai_{{ $item->id }}" class="checkbox accent-yellow-500">
                                                    <label for="pegawai_{{ $item->id }}" class="ml-2 text-gray-800 font-medium">{{ $item->name }} - {{ $item->bidang->name }}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-6 py-3 sm:px-6 sm:flex sm:flex-row-reverse space-x-2 space-x-reverse">
                                <button type="button" id="saveParticipantsButton" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-4 py-2 rounded-lg transition duration-300">Simpan</button>
                                <button type="button" id="closeModalButton" class="bg-gray-400 hover:bg-gray-500 text-white font-semibold px-4 py-2 rounded-lg transition duration-300">Batal</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit mt-6">Simpan Agenda</button>
        </form>
    </div>

    <!-- Daftar Agenda -->
    <h2 class="text-3xl font-semibold text-gray-800 mb-6">Daftar Agenda</h2>
    <div id="agenda-table-container">
        @if ($agendas->isEmpty())
        <p class="text-gray-600">Tidak ada agenda yang tersedia.</p>
        @else
        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Nama Acara</th>
                        <th class="px-4 py-2">Kategori</th>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Waktu</th>
                        <th class="px-4 py-2">Lokasi</th>
                        <th class="px-4 py-2">Undangan</th>
                        <th class="px-4 py-2">Laporan</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody @if (auth()->user()->role_id == 3) style="display: none;" @endif>
                    @foreach ($agendas as $agenda)
                    @php
                    $currentDateTime = \Carbon\Carbon::now();
                    $endDateTime = \Carbon\Carbon::parse($agenda->tanggal_selesai . ' ' . $agenda->waktu_selesai);
                    $isCompleted = $currentDateTime->greaterThanOrEqualTo($endDateTime);
                    @endphp
                    <tr data-kategori="{{ $agenda->kategori }}" class="{{ $loop->odd ? 'bg-gray-100' : 'bg-white' }} hover:bg-gray-200 transition duration-200 {{ $isCompleted ? 'bg-green-100' : 'bg-red-100' }}">
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ $agenda->nama_acara }}</td>
                        <td class="px-4 py-2">{{ $agenda->kategori }}</td>
                        <td class="px-4 py-2">{{ $agenda->tanggal_mulai }} - {{ $agenda->tanggal_selesai }}</td>
                        <td class="px-4 py-2">{{ $agenda->waktu_mulai }} - {{ $agenda->waktu_selesai }}</td>
                        <td class="px-4 py-2">{{ $agenda->tempat }}</td>
                        <td class="px-4 py-2">
                            <ul class="list-disc pl-4">
                                @foreach (json_decode($agenda->list_daftar_nama, true) as $pegawai_id)
                                @php
                                $pegawai = App\Models\Pegawai::find($pegawai_id);
                                @endphp
                                <li>{{ $pegawai ? $pegawai->name . '-' . $pegawai->bidang->name : 'Tidak ditemukan' }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <button class="toggle-laporan px-4 py-2 {{ $isCompleted ? 'bg-green-500' : 'bg-red-500' }} text-white rounded-lg" data-id="{{ $agenda->id }}">
                                {{ $isCompleted ? 'Selesai' : 'Belum' }}
                            </button>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('meeting-rooms.edit', $agenda->id) }}" class="text-blue-500 hover:text-blue-700">
                                <i class='bx bx-edit-alt bx-sm'></i>
                                Edit
                            </a>
                            <form action="{{ route('meeting-rooms.destroy', $agenda->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <i class='bx bx-trash bx-sm'></i>
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-4 py-3">
                {{ $agendas->links() }}
            </div>
        </div>
        @endif
    </div>

    <script>
        document.getElementById('openModalButton').addEventListener('click', function() {
            document.getElementById('participantModal').classList.remove('hidden');
        });

        document.getElementById('closeModalButton').addEventListener('click', function() {
            document.getElementById('participantModal').classList.add('hidden');
        });

        document.getElementById('saveParticipantsButton').addEventListener('click', function() {
            const selectedParticipants = document.querySelectorAll('#list_daftar_nama .checkbox:checked');
            const selectedParticipantsContainer = document.getElementById('selectedParticipants');
            selectedParticipantsContainer.innerHTML = '';

            selectedParticipants.forEach(participant => {
                const label = document.querySelector(`label[for="${participant.id}"]`).textContent;
                const div = document.createElement('div');
                div.textContent = label;
                selectedParticipantsContainer.appendChild(div);
            });

            document.getElementById('participantModal').classList.add('hidden');
        });

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

        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.toggle-laporan');

            buttons.forEach(button => {
            button.addEventListener('click', function() {
                const agendaId = this.dataset.id;

                fetch(`/meeting-rooms/${agendaId}/toggle-laporan`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                })
                .then(response => response.json())
                .then(data => {
                if (data.status === 'success') {
                    const row = this.closest('tr');
                    row.classList.toggle('bg-red-100', !data.report);
                    row.classList.toggle('bg-green-100', data.report);
                    this.classList.toggle('bg-red-500', !data.report);
                    this.classList.toggle('bg-green-500', data.report);
                    this.textContent = data.report ? 'Selesai' : 'Belum';
                } else {
                    alert('Gagal memperbarui status laporan.');
                }
                })
                .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan.');
                });
            });
            });

            // Update row colors based on current time
            const rows = document.querySelectorAll('tbody tr');
            const currentDateTime = new Date();

            rows.forEach(row => {
            const endDateTime = new Date(row.querySelector('td:nth-child(4)').textContent.split(' - ')[1] + ' ' + row.querySelector('td:nth-child(5)').textContent.split(' - ')[1]);
            const isCompleted = currentDateTime >= endDateTime;

            row.classList.toggle('bg-green-100', isCompleted);
            row.classList.toggle('bg-red-100', !isCompleted);
            const button = row.querySelector('.toggle-laporan');
            button.classList.toggle('bg-green-500', isCompleted);
            button.classList.toggle('bg-red-500', !isCompleted);
            button.textContent = isCompleted ? 'Selesai' : 'Belum';
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.select-row');
            const deleteButton = document.getElementById('deleteButton');
            const editButton = document.getElementById('editButton');

            // Handle select all
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(checkbox => checkbox.checked = selectAll.checked);
                toggleButtons();
            });

            // Handle individual checkbox click
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', toggleButtons);
            });

            function toggleButtons() {
                const selectedCount = document.querySelectorAll('.select-row :checked').length;
                deleteButton.disabled = selectedCount === 0;
                editButton.disabled = selectedCount !== 1;
            }

            // Handle edit button click
            editButton.addEventListener('click', function() {
                const selectedId = document.querySelector('.select-row:checked').value;
                if (selectedId) {
                    window.location.href = `/meeting-rooms/${selectedId}/edit`;
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            // Fungsi untuk menyaring tabel berdasarkan kategori
            function filterTableByCategory() {
                // Ambil semua baris tabel
                const rows = document.querySelectorAll("tbody tr");

                // Iterasi setiap baris
                rows.forEach((row) => {
                    // Ambil data kategori dari atribut data-kategori
                    const category = row.getAttribute("data-kategori");

                    // Periksa apakah kategori adalah "Penting" atau "Biasa"
                    if (category === "Penting" || category === "Biasa") {
                        // Sembunyikan baris dengan kategori "Penting" atau "Biasa"
                        row.style.display = "none";
                    } else if (category === "Rapat") {
                        // Tampilkan baris dengan kategori "Rapat"
                        row.style.display = "table-row";
                    }
                });
            }

            // Panggil fungsi filterTableByCategory saat halaman dimuat
            filterTableByCategory();
        });

        // fitur select nama user
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