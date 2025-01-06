@extends('layouts.app')
@extends('layouts.navigation')
@extends('layouts.favicon')

@section('content')
@include('components.popup')
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
    <!-- Kategori Umum -->
    <div class="status-item p-6 bg-gradient-to-r from-blue-400 to-blue-500 rounded-lg shadow-xl transform transition-all hover:scale-105 hover:shadow-2xl">
        <div class="flex items-center space-x-4">
            <div class="bg-white p-3 rounded-full">
                <i class="bx bx-info-circle text-4xl text-blue-500"></i>
            </div>
            <h3 class="text-white text-xl font-semibold">Kategori Biasa</h3>
        </div>
        <p class="text-4xl text-white font-bold mt-2">{{ $agendaCount['biasa'] }}</p>
    </div>

    <!-- Kategori Penting -->
    <div class="status-item p-6 bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-lg shadow-xl transform transition-all hover:scale-105 hover:shadow-2xl">
        <div class="flex items-center space-x-4">
            <div class="bg-white p-3 rounded-full">
                <i class="bx bx-task text-4xl text-yellow-500"></i>
            </div>
            <h3 class="text-white text-xl font-semibold">Kategori Penting</h3>
        </div>
        <p class="text-4xl text-white font-bold mt-2">{{ $agendaCount['penting'] }}</p>
    </div>

    <!-- Kategori Rapat -->
    <div class="status-item p-6 bg-gradient-to-r from-green-400 to-green-500 rounded-lg shadow-xl transform transition-all hover:scale-105 hover:shadow-2xl">
        <div class="flex items-center space-x-4">
            <div class="bg-white p-3 rounded-full">
                <i class="bx bx-group text-4xl text-green-500"></i>
            </div>
            <h3 class="text-white text-xl font-semibold">Kategori Rapat</h3>
        </div>
        <p class="text-4xl text-white font-bold mt-2">{{ $agendaCount['rapat'] }}</p>
    </div>
</div>

<div class="container mx-auto p-4">
    <!-- Form Filter dan Button Salin WA -->
    <div class="mb-8">
        <form method="GET" action="{{ route('dashboard') }}" class="grid grid-cols-3 gap-4">
            <!-- Filter Nama Acara -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Nama Acara</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Cari nama acara...">
            </div>

            <!-- Filter Tanggal Mulai dan Selesai -->
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Filter Kategori -->
            <div>
                <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="kategori" id="kategori" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Pilih Kategori</option>
                    <option value="Biasa" {{ request('kategori') == 'Biasa' ? 'selected' : '' }}>Biasa</option>
                    <option value="Penting" {{ request('kategori') == 'Penting' ? 'selected' : '' }}>Penting</option>
                    <option value="Rapat" {{ request('kategori') == 'Rapat' ? 'selected' : '' }}>Rapat</option>
                </select>
            </div>

            <div class="col-span-3 text-right space-x-2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Terapkan Filter</button>
                <button type="button" id="reset-btn" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Reset Filter</button>
            </div>
        </form>

        <!-- Button Salin WA -->
        <div class="text-right mt-4">
            <button id="copy-wa-btn" class="bg-green-500 text-white px-4 py-2 rounded-lg">
                <box-icon name='whatsapp' type='logo' color='white'></box-icon> Salin Semua ke WA
            </button>
        </div>

        <table class="table-auto w-full border-collapse bg-white rounded-lg shadow-lg">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Nama Acara</th>
                    <th class="px-4 py-2 border">Kategori</th>
                    <th class="px-4 py-2 border">Tanggal</th>
                    <th class="px-4 py-2 border">Waktu</th>
                    <th class="px-4 py-2 border">Lokasi</th>
                    <th class="px-4 py-2 border">Undangan</th>
                </tr>
            </thead>
            <tbody id="agenda-table-body">
                @foreach ($agendas as $agenda)
                <tr class="hover:bg-gray-50"
                    data-tanggal="{{ $agenda->tanggal_mulai }}"
                    data-waktu-mulai="{{ $agenda->waktu_mulai }}">
                    <td class="px-4 py-2 border text-center">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border">{{ $agenda->nama_acara }}</td>
                    <td class="px-4 py-2 border">{{ $agenda->kategori }}</td>
                    <td class="px-4 py-2 border">{{ $agenda->tanggal_mulai }} sampai {{ $agenda->tanggal_selesai }}</td>
                    <td class="px-4 py-2 border">{{ $agenda->waktu_mulai }} - {{ $agenda->waktu_selesai }}</td>
                    <td class="px-4 py-2 border">{{ $agenda->tempat }}</td>
                    <td class="px-4 py-2 border">
                        @php
                        $listNama = json_decode($agenda->list_daftar_nama, true);
                        @endphp

                        @if (!empty($listNama))
                        <ul>
                            @foreach ($listNama as $user_id)
                            <li>{{ App\Models\User::find($user_id)->name ?? 'Tidak ditemukan' }}</li>
                            @endforeach
                        </ul>
                        @else
                        Tidak ada peserta
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>


        <div class="mt-4">
            {{ $agendas->links() }}
        </div>
    </div>

    <script>
        function addNewRow(data) {
            const tableBody = document.getElementById('agenda-table-body');

            // Format tanggal, waktu, dan nama peserta jika diperlukan
            const pesertaList = data.list_daftar_nama.map(user => `<li>${user.name}</li>`).join('');

            // Buat elemen baris baru
            const newRow = `
        <tr class="hover:bg-gray-50" data-tanggal="${data.tanggal_mulai}">
            <td class="px-4 py-2 border text-center">#</td>
            <td class="px-4 py-2 border">${data.nama_acara}</td>
            <td class="px-4 py-2 border">${data.kategori}</td>
            <td class="px-4 py-2 border">${data.tanggal_mulai} sampai ${data.tanggal_selesai}</td>
            <td class="px-4 py-2 border">${data.waktu_mulai} - ${data.waktu_selesai}</td>
            <td class="px-4 py-2 border">${data.tempat}</td>
            <td class="px-4 py-2 border">
                <ul>${pesertaList}</ul>
            </td>
        </tr>
    `;

            // Sisipkan baris baru di posisi pertama
            tableBody.insertAdjacentHTML('afterbegin', newRow);

            // Perbarui nomor urut
            updateRowNumbers();
        }

        function updateRowNumbers() {
            const rows = document.querySelectorAll('#agenda-table-body tr');
            rows.forEach((row, index) => {
                row.querySelector('td').textContent = index + 1;
            });
        }
        // fungsi filter dan reset
        document.addEventListener('DOMContentLoaded', function() {
            const resetBtn = document.getElementById('reset-btn');
            const form = document.querySelector('form');

            // Reset Filter
            resetBtn.addEventListener('click', function() {
                form.reset(); // Reset form inputs
                form.submit(); // Resubmit to clear filters
                window.location.href = '{{ route("dashboard") }}';
            });

        });
        document.getElementById('copy-wa-btn').addEventListener('click', function() {
            // Mendapatkan tanggal dan waktu saat ini
            const now = new Date();
            const today = now.toISOString().split('T')[0]; // Format YYYY-MM-DD
            const currentTime = now.toTimeString().split(' ')[0]; // Format HH:MM:SS
            let textToCopy = '';

            // Mendapatkan semua baris dalam tabel
            const rows = Array.from(document.querySelectorAll('#agenda-table-body tr'));

            // Menyortir baris berdasarkan tanggal dan waktu
            rows.sort((a, b) => {
                const tanggalA = a.getAttribute('data-tanggal');
                const tanggalB = b.getAttribute('data-tanggal');
                const waktuA = a.getAttribute('data-waktu-mulai');
                const waktuB = b.getAttribute('data-waktu-mulai');

                if (tanggalA === tanggalB) {
                    return waktuA.localeCompare(waktuB); // Urutkan berdasarkan waktu jika tanggal sama
                }
                return tanggalA.localeCompare(tanggalB); // Urutkan berdasarkan tanggal
            });

            // Iterasi melalui setiap baris setelah diurutkan
            rows.forEach((row, index) => {
                const tanggalMulai = row.getAttribute('data-tanggal');
                const waktuMulai = row.getAttribute('data-waktu-mulai');

                // Logika untuk membatasi data hingga pukul 23:59 hari ini
                
                    // Mengambil data dari kolom yang diinginkan
                    const no = index + 1; // Nomor urut setelah sorting
                    const namaAcara = row.cells[1].innerText;
                    const kategori = row.cells[2].innerText;
                    const tanggal = row.cells[3].innerText;
                    const waktu = row.cells[4].innerText;
                    const lokasi = row.cells[5].innerText;
                    const undangan = row.cells[6].innerText;

                    // Menyusun teks yang akan disalin
                    textToCopy += `No: ${no}\nNama Acara: ${namaAcara}\nKategori: ${kategori}\nTanggal: ${tanggal}\nWaktu: ${waktu}\nLokasi: ${lokasi}\nUndangan: ${undangan}\n\n`;
            });

            // Menyalin teks ke clipboard
            if (textToCopy) {
                navigator.clipboard.writeText(textToCopy).then(() => {
                    alert('Data berhasil disalin ke clipboard!');
                }).catch(err => {
                    console.error('Gagal menyalin: ', err);
                });
            } else {
                alert('Tidak ada agenda untuk hari ini sebelum pukul 23:59.');
            }
        });

        // Fungsi untuk menyembunyikan data di hari-hari lain
        function filterAgendaByToday() {
            const today = new Date().toISOString().split('T')[0]; // Format YYYY-MM-DD
            const rows = Array.from(document.querySelectorAll('#agenda-table-body tr'));

            rows.forEach(row => {
                const tanggalMulai = row.getAttribute('data-tanggal');
                // Hanya tampilkan baris dengan tanggal sama dengan hari ini
                if (tanggalMulai !== today) {
                    row.style.display = 'none'; // Sembunyikan baris
                } else {
                    row.style.display = ''; // Tampilkan baris
                }
            });
        }

        // Jalankan filter saat halaman dimuat
        window.onload = filterAgendaByToday;
    </script>

    @endsection