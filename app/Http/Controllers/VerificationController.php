<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\User;
use App\Models\Bidang;

class VerificationController extends Controller
{
    // Menampilkan halaman validasi NIP untuk role_id 3
    public function showValidationForm()
    {
        return view('pegawai.validate-nip');
    }

    // Memvalidasi NIP dan memperbarui role user
    public function validateNip(Request $request)
    {
        $request->validate([
            'nip' => 'required|string|max:18|exists:pegawai,nip',
        ]);

        // Cek apakah NIP sudah digunakan
        $pegawai = Pegawai::where('nip', $request->nip)->first();

        if ($pegawai && !$pegawai->is_verified) {
            // Update status pegawai
            $pegawai->is_verified = true;
            $pegawai->save();

            // Update role_id user
            $user = User::find(auth()->id());
            $user->role_id = 2; // Ubah ke role Staff
            $user->save();

            return redirect()->route('dashboard')->with('success', 'NIP berhasil diverifikasi! Anda kini memiliki akses sebagai Staff.');
        }

        return back()->withErrors(['nip' => 'NIP tidak valid atau sudah digunakan.']);
    }

    // Menampilkan halaman create pegawai untuk role_id 1 dan 2
    public function showCreateForm()
    {
        if (auth()->user()->role_id != 1 && auth()->user()->role_id != 2) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses untuk membuat data pegawai.');
        }

        $bidangs = Bidang::all();
        $pegawai = Pegawai::all(); // Menampilkan data pegawai di tabel
        return view('pegawai.create-pegawai', compact('bidangs', 'pegawai'));
    }

    // Menyimpan data pegawai baru
    public function createPegawai(Request $request)
    {
        if (auth()->user()->role_id != 1 && auth()->user()->role_id != 2) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses untuk menyimpan data pegawai.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|max:18|unique:pegawai,nip',
            'bidang_id' => 'required|exists:bidang,id',
        ]);

        Pegawai::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'bidang_id' => $request->bidang_id,
            'is_verified' => false,
        ]);

        return back()->with('success', 'Data pegawai berhasil disimpan.');
    }
}
