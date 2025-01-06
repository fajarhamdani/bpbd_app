<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role_id', [2, 3])
            ->with(['bidang', 'role']) // Jika relasi digunakan
            ->paginate(25); // Atur paginasi sesuai kebutuhan

        // Kirim data ke view
        return view('users.index', compact('users'));
    }

    public function promoteToAdmin($userId)
    {
        // Cari pengguna berdasarkan ID
        $user = User::findOrFail($userId);

        // Periksa apakah user sudah admin, jika belum, promosi jadi admin
        if ($user->role_id !== 1) {
            $user->role_id = 1; // Anggap 1 adalah ID untuk role admin
            $user->save();

            // Redirect kembali dengan pesan sukses
            return redirect()->route('users.index')->with('status', 'User berhasil dipromosikan menjadi Admin');
        }

        // Jika sudah admin, beri pemberitahuan
        return redirect()->route('users.index')->with('status', 'User sudah merupakan Admin');
    }

    public function delete($userId)
    {
        // Cari pengguna berdasarkan ID
        $user = User::findOrFail($userId);

        // Pastikan hanya admin yang dapat menghapus user
        if (auth()->check() && auth()->user()->role_id === 1) { // Cek apakah pengguna sudah login dan role-nya admin
            // Hapus user
            $user->delete();

            // Redirect kembali dengan pesan sukses
            return redirect()->route('users.index')->with('status', 'User berhasil dihapus');
        }

        // Jika pengguna bukan admin atau belum login, beri pemberitahuan
        return redirect()->route('users.index')->with('status', 'Anda tidak memiliki hak untuk menghapus user');
    }

    public function destroy(Request $request, $id)
    {
        $currentUser = auth()->user();

        // Pastikan user tidak menghapus dirinya sendiri
        if ($currentUser->id == $id) {
            return redirect()->back()->with('status', 'error|Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        // Cek apakah yang akan dihapus adalah admin
        if ($user->role_id === '1') {
            return redirect()->back()->with('status', 'error|Anda tidak dapat menghapus akun sesama admin.');
        }

        // Lakukan penghapusan
        $user->delete();

        return redirect()->route('users.index')->with('status', 'success|Pengguna berhasil dihapus.');
    }
}
