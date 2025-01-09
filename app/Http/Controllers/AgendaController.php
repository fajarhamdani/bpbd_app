<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\User;
use App\Models\Bidang;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{

    // Menampilkan daftar agenda dengan kategori 'meeting'
    public function index()
    {
        $today = Carbon::today();
        $pegawai = Pegawai::all();
        $agendas = Agenda::with('bidang', 'users', 'pegawai') // Memuat relasi 'bidang', 'users', dan 'pegawai'
            ->whereDate('tanggal_mulai', '>=', $today->subDay()) // Menyaring agenda yang tanggal mulainya adalah kemarin, hari ini, besok, dan seterusnya
            ->orderBy('tanggal_mulai', 'asc') // Mengurutkan berdasarkan tanggal mulai secara ascending
            ->orderBy('waktu_mulai', 'asc') // Mengurutkan berdasarkan waktu mulai secara ascending
            ->paginate(25); // Ambil semua agenda dengan relasi ke bidang
        $users = User::where('role_id', 1)->orWhere('role_id', 2)->get();
        $bidangs = Bidang::all(); // Ambil semua bidang untuk form create
        return view('agendas.index', compact('agendas', 'bidangs', 'users', 'pegawai'));
    }

    public function toggleLaporan($id)
    {
        if (!in_array(auth()->user()->role_id, [1, 2])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki hak untuk mengubah status laporan.',
            ], 403);
        }

        $agenda = Agenda::findOrFail($id); // Cari agenda berdasarkan ID
        $agenda->report = !$agenda->report; // Toggle status laporan
        $agenda->save(); // Simpan perubahan

        return response()->json([
            'status' => 'success',
            'message' => 'Status laporan berhasil diperbarui.',
            'report' => $agenda->report, // Status laporan terbaru
        ]);
    }

    public function store(Request $request)
    {
        // Validasi: Hanya role_id 1 (Admin) dan 2 (Staff) yang dapat membuat agenda
        if (!in_array(auth()->user()->role_id, [1, 2])) {
            return redirect()->route('agendas.index')->with('error', 'Anda tidak memiliki hak untuk membuat agenda.');
        }

        // Validasi data
        $request->validate([
            'nama_acara' => 'required|string|max:255',
            'kategori' => 'required|string|in:Penting,Biasa,Rapat', // Validasi kategori
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'tempat' => 'required|string|max:255',
            'list_daftar_nama' => 'required|array', // Validasi untuk daftar nama
            'list_daftar_nama.*' => 'exists:pegawai,id',
        ]);
        // Buat agenda baru
        Agenda::create([
            'nama_acara' => $request->nama_acara,
            'kategori' => $request->kategori, // Menyimpan kategori
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'tempat' => $request->tempat,
            'list_daftar_nama' => json_encode($request->list_daftar_nama),  // Catat siapa yang membuat
        ]);

        return redirect()->route('agendas.index')->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        // Validasi: Hanya Admin (role_id 1) yang bisa menghapus agenda
        if (auth()->user()->role_id !== 1) {
            return redirect()->route('agendas.index')->with('error', 'Anda tidak memiliki hak untuk menghapus agenda.');
        }

        $agenda = Agenda::findOrFail($id); // Cari agenda berdasarkan ID

        // Hapus agenda
        $agenda->delete();

        return redirect()->route('agendas.index')->with('success', 'Agenda berhasil dihapus.');
    }

    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id); // Cari agenda berdasarkan ID
        $users = User::where('role_id', 1)->orWhere('role_id', 2)->get();
        $pegawai = Pegawai::all();
        $bidangs = Bidang::all(); // Ambil semua bidang untuk form edit

        return view('agendas.edit', compact('agenda', 'bidangs', 'users', 'pegawai'));
    }

    public function update(Request $request, $id)
    {
        // Validasi: Hanya Admin (role_id 1) dan Staff (role_id 2) yang bisa mengedit agenda
        if (!in_array(auth()->user()->role_id, [1, 2])) {
            return redirect()->route('agendas.index')->with('error', 'Anda tidak memiliki hak untuk mengedit agenda.');
        }

        $agenda = Agenda::findOrFail($id); // Cari agenda berdasarkan ID

        // Validasi data
        $request->validate([
            'nama_acara' => 'required|string|max:255',
            'kategori' => 'required|string|in:Penting,Biasa,Rapat',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'tempat' => 'required|string|max:255',
            'list_daftar_nama' => 'required|array',
            'list_daftar_nama.*' => 'exists:pegawai,id',
        ]);
        // Update agenda
        $agenda->update([
            'nama_acara' => $request->nama_acara,
            'kategori' => $request->kategori,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'tempat' => $request->tempat,
            'list_daftar_nama' => json_encode($request->list_daftar_nama), // Simpan dalam bentuk JSON
        ]);

        return redirect()->route('agendas.index')->with('success', 'Agenda berhasil diperbarui.');
    }
}
