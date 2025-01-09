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
        <form method="GET" action="{{ route('dashboard') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Filter Nama Acara -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Nama Acara</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Cari nama acara...">
            </div>

            <!-- Filter Tanggal Mulai -->
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Filter Tanggal Selesai -->
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

            <div class="col-span-1 sm:col-span-2 lg:col-span-4 text-right space-x-2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Terapkan Filter</button>
                <button type="button" id="reset-btn" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Reset Filter</button>
            </div>
        </form>

        <!-- Button Salin WA -->
        <div class="text-right mt-4">
            <button id="copy-wa-btn" class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center justify-center space-x-2">
                <box-icon name='whatsapp' type='logo' color='white'></box-icon>
                <span>Salin Semua ke Format WA</span>
            </button>
        </div>
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
            <tr class="hover:bg-gray-50">
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
                        @foreach (json_decode($agenda->list_daftar_nama, true) as $pegawai_id)
                        @php
                        $pegawai = App\Models\Pegawai::find($pegawai_id);
                        @endphp
                        <li>{{ $pegawai ? $pegawai->name . ' - ' . $pegawai->bidang->name : 'Tidak ditemukan' }}</li>
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
    document.addEventListener('DOMContentLoaded', () => {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const resetButton = document.getElementById('reset-btn');
        const copyWaBtn = document.getElementById('copy-wa-btn');
        const form = document.querySelector('form');

        // Ensure end_date is required when start_date is selected
        startDateInput.addEventListener('change', () => {
            if (startDateInput.value) {
                endDateInput.setAttribute('required', 'required');
            } else {
                endDateInput.removeAttribute('required');
            }
        });

        // Handle the reset filter functionality
        resetButton.addEventListener('click', () => {
            form.reset(); // Mengatur ulang semua input ke nilai default
            filterInputs.forEach(input => input.value = ''); // Pastikan semua input kosong
            endDateInput.removeAttribute('required'); // Pastikan end_date tidak wajib
            window.location.href = "{{ route('dashboard') }}"; // Redirect to clear query parameters
        });

        // Filter data dynamically based on inputs
        const filterInputs = document.querySelectorAll('#search, #start_date, #end_date, #kategori');
        filterInputs.forEach(input => {
            input.addEventListener('change', () => filterData());
        });

        form.addEventListener('submit', (event) => {
            event.preventDefault();
            filterData();
        });
        // function filterData
        function filterData(reset = false) {
            const searchValue = reset ? '' : document.getElementById('search').value.toLowerCase().trim(); // Case-insensitive
            const startDateValue = reset ? '' : startDateInput.value;
            const endDateValue = reset ? '' : endDateInput.value;
            const kategoriValue = reset ? '' : document.getElementById('kategori').value;

            const tableBody = document.getElementById('agenda-table-body');
            const rows = tableBody.querySelectorAll('tr');

            rows.forEach(row => {
                const namaAcara = row.querySelector('td:nth-child(2)').textContent.toLowerCase().trim(); // Pastikan lower-case dan trim
                const kategori = row.querySelector('td:nth-child(3)').textContent.trim();
                const tanggal = row.querySelector('td:nth-child(4)').textContent.trim();

                const [start, end] = tanggal.split(' sampai ').map(date => new Date(date.trim()));

                const matchesSearch = !searchValue || namaAcara.includes(searchValue);
                const matchesStartDate = !startDateValue || start >= new Date(startDateValue);
                const matchesEndDate = !endDateValue || end <= new Date(endDateValue);
                const matchesKategori = !kategoriValue || kategori === kategoriValue;

                if (matchesSearch && matchesStartDate && matchesEndDate && matchesKategori) {
                    row.style.display = ''; // Tampilkan baris jika cocok
                } else {
                    row.style.display = 'none'; // Sembunyikan baris jika tidak cocok
                }
            });
        }

        // Handle the reset filter functionality
        resetButton.addEventListener('click', () => {
            form.reset(); // Mengatur ulang semua input ke nilai default
            filterData(true); // Tampilkan semua data
            endDateInput.removeAttribute('required'); // Pastikan end_date tidak wajib
        });

        // Copy filtered data to WhatsApp
        copyWaBtn.addEventListener('click', () => {
            const tableBody = document.getElementById('agenda-table-body');
            const rows = Array.from(tableBody.querySelectorAll('tr')).filter(row => row.style.display !== 'none');

            if (rows.length === 0) {
                alert('Tidak ada data yang sesuai dengan filter.');
                return;
            }

            let textToCopy = '';
            rows.forEach((row, index) => {
                const no = index + 1;
                const namaAcara = row.querySelector('td:nth-child(2)').textContent;
                const kategori = row.querySelector('td:nth-child(3)').textContent;
                const tanggal = row.querySelector('td:nth-child(4)').textContent;
                const waktu = row.querySelector('td:nth-child(5)').textContent;
                const lokasi = row.querySelector('td:nth-child(6)').textContent;

                // Handle "Undangan" content and ensure proper formatting
                const undanganCell = row.querySelector('td:nth-child(7)');
                const undangan = Array.from(undanganCell.querySelectorAll('li'))
                    .map(li => li.textContent.trim())
                    .filter(text => text !== '') // Remove empty texts
                    .join(', '); // Combine with comma and space

                textToCopy += `No: ${no}\nNama Acara: ${namaAcara}\nKategori: ${kategori}\nTanggal: ${tanggal}\nWaktu: ${waktu}\nLokasi: ${lokasi}\nUndangan: ${undangan}\n\n`;
            });

            // Copy text to clipboard
            navigator.clipboard.writeText(textToCopy)
                .then(() => {
                    alert('Data berhasil disalin ke clipboard!');
                })
                .catch(err => {
                    console.error('Gagal menyalin: ', err);
                });
        });
    });
</script>

@endsection