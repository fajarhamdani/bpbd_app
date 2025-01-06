<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        // Cek apakah pegawai sudah diverifikasi
        $pegawai = auth()->user()->pegawai; // Ambil data pegawai yang terhubung dengan user

        if ($pegawai && $pegawai->is_verified === false) {
            return redirect()->route('verifikasi'); // Arahkan ke halaman verifikasi
        }

        // Tampilkan halaman pegawai jika sudah diverifikasi
        $pegawaiList = Pegawai::all();
        return view('pegawai.index', compact('pegawaiList'));
    }
}
