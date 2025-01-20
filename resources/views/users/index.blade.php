@extends('layouts.app')
@extends('layouts.navigation')
@extends('layouts.favicon')

@section('content')
@include('components.popup')
<link href="{{ asset('css/media-userdata.css') }}" rel="stylesheet">
<div class="max-w-7xl mx-auto bg-white shadow-lg rounded-lg p-4 md:p-6 lg:p-8 user-management-container custom-container-class">
    <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 mb-4 md:mb-6 lg:mb-8 user-management-title">Manajemen Data Pegawai</h1>

    @if(session('status'))
    @php
    $status = session('status');
    $type = 'error';
    $message = 'Terjadi kesalahan';
    if (strpos($status, '|') !== false) {
    [$type, $message] = explode('|', $status);
    } else {
    $message = $status;
    }
    @endphp
    <div class="mb-4 md:mb-6 lg:mb-8 p-2 md:p-4 rounded-lg text-white {{ $type === 'success' ? 'bg-red-500' : 'bg-green-500' }} status-message">
        {{ $message }}
    </div>
    @endif
    <table class="min-w-full bg-gray-50 rounded-lg border-separate border-spacing-0 shadow-sm user-table">
        <thead class="bg-gray-500">
            <tr>
                <th class="px-2 py-2 md:px-4 md:py-4 lg:px-6 lg:py-4 text-left text-white font-semibold">ID User</th>
                <th class="px-2 py-2 md:px-4 md:py-4 lg:px-6 lg:py-4 text-left text-white font-semibold">Nama</th>
                <th class="px-2 py-2 md:px-4 md:py-4 lg:px-6 lg:py-4 text-left text-white font-semibold">Email</th>
                <th class="px-2 py-2 md:px-4 md:py-4 lg:px-6 lg:py-4 text-left text-white font-semibold">Bidang</th>
                <th class="px-2 py-2 md:px-4 md:py-4 lg:px-6 lg:py-4 text-left text-white font-semibold">Role</th>
                @if(auth()->user()->role_id != 2 && auth()->user()->role_id != 3)
                <th class="px-2 py-2 md:px-4 md:py-4 lg:px-6 lg:py-4 text-left text-white font-semibold">Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody class="text-sm text-gray-700">
            @if(auth()->user()->role_id === 3)
            <tr>
                <td colspan="6" class="text-center py-4 text-gray-500">
                    Role User - Anda tidak dapat melihat data pengguna lain.
                </td>
            </tr>
            @else
            @forelse ($users as $user)
            <tr class="{{ $loop->odd ? 'bg-gray-100' : 'bg-white' }} hover:bg-gray-200 transition duration-200 user-row">
                <td class="px-2 py-2 md:px-4 md:py-4 lg:px-6 lg:py-4">{{ $user->custom_id }}</td>
                <td class="px-2 py-2 md:px-4 md:py-4 lg:px-6 lg:py-4">{{ $user->name }}</td>
                <td class="px-2 py-2 md:px-4 md:py-4 lg:px-6 lg:py-4">{{ $user->email }}</td>
                <td class="px-2 py-2 md:px-4 md:py-4 lg:px-6 lg:py-4">{{ $user->bidang_name }}</td>
                <td class="px-2 py-2 md:px-4 md:py-4 lg:px-6 lg:py-4">{{ $user->role_name }}</td>
                @if(auth()->user()->role_id != 2)
                <td class="px-2 py-2 md:px-4 md:py-4 lg:px-6 lg:py-4">
                    <div class="flex space-x-1 md:space-x-2 action-buttons">
                        <form action="{{ route('users.promote', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="px-2 py-1 md:px-4 md:py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-200">
                                Promosi
                            </button>
                        </form>
                        <form action="{{ route('users.delete', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="px-2 py-1 md:px-4 md:py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-200" onclick="confirmDelete('{{ $user->name }}', this.form);">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-4 text-gray-500">
                    Tidak ada data pengguna yang tersedia.
                </td>
            </tr>
            @endforelse
            @endif
        </tbody>
    </table>

    <div class="mt-4 md:mt-6 lg:mt-8 pagination-links">
        {{ $users->links() }}
    </div>
</div>

<!-- SweetAlert Notification -->
@if(session('status'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let statusMessage = "{{ session('status') }}";
        let type = statusMessage.includes('berhasil') ? 'success' : 'error';

        // SweetAlert for notification
        Swal.fire({
            title: type === 'success' ? 'Berhasil!' : 'Gagal!',
            text: statusMessage,
            icon: type,
            confirmButtonText: 'Ok'
        });
    });
</script>
@endif

<script>
    function confirmDelete(userName, form) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: `Anda akan menghapus user "${userName}". Tindakan ini tidak dapat dibatalkan!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>

@endsection