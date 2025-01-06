@extends('layouts.app')
@extends('layouts.navigation')
@extends('layouts.favicon')

@section('content')
@include('components.popup')
<div class="max-w-7xl mx-auto bg-white shadow-lg rounded-lg p-8">
    <h1 class="text-4xl font-bold text-gray-800 mb-8">Manajemen Data User</h1>

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
    <div class="mb-6 p-4 rounded-lg text-white {{ $type === 'success' ? 'bg-green-500' : 'bg-red-500' }}">
        {{ $message }}
    </div>
    @endif
    <table class="min-w-full bg-gray-50 rounded-lg border-separate border-spacing-0 shadow-sm">
        <thead class="bg-gray-500">
            <tr>
                <th class="px-6 py-4 text-left text-white font-semibold">ID User</th>
                <th class="px-6 py-4 text-left text-white font-semibold">Nama</th>
                <th class="px-6 py-4 text-left text-white font-semibold">Email</th>
                <th class="px-6 py-4 text-left text-white font-semibold">Bidang</th>
                <th class="px-6 py-4 text-left text-white font-semibold">Role</th>
                @if(auth()->user()->role_id != 2 && auth()->user()->role_id != 3)
                <th class="px-6 py-4 text-left text-white font-semibold">Aksi</th>
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
            <tr class="{{ $loop->odd ? 'bg-gray-100' : 'bg-white' }} hover:bg-gray-200 transition duration-200">
                <td class="px-6 py-4">{{ $user->custom_id }}</td>
                <td class="px-6 py-4">{{ $user->name }}</td>
                <td class="px-6 py-4">{{ $user->email }}</td>
                <td class="px-6 py-4">{{ $user->bidang_name }}</td>
                <td class="px-6 py-4">{{ $user->role_name }}</td>
                @if(auth()->user()->role_id != 2)
                <td class="px-6 py-4">
                    <div class="flex space-x-2">
                        <form action="{{ route('users.promote', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-200">
                                Promosi
                            </button>
                        </form>
                        <form action="{{ route('users.delete', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition duration-200" onclick="confirmDelete('{{ $user->name }}', this.form);">
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


    <div class="mt-6">
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