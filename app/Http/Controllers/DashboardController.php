<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Bidang;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Menghitung jumlah agenda berdasarkan kategori
        $agendaCount = [
            'biasa' => Agenda::where('kategori', 'Biasa')->count(),
            'penting' => Agenda::where('kategori', 'Penting')->count(),
            'rapat' => Agenda::where('kategori', 'Rapat')->count(),
        ];

        // Ambil data filter dari request
        $search = $request->input('search'); // Nama acara
        $startDate = $request->input('start_date'); // Tanggal mulai
        $endDate = $request->input('end_date'); // Tanggal selesai
        $kategori = $request->input('kategori'); // Kategori

        // Jika tidak ada filter, kembalikan semua data
        if (!$search && !$startDate && !$endDate && !$kategori) {
            $agendas = Agenda::all();
        } else {
            // Mulai query agenda
            $query = Agenda::query();

            // Filter berdasarkan nama acara
            if ($search) {
                $query->whereRaw('LOWER(nama_acara) LIKE ?', [strtolower($search)]);
            }

            // Filter berdasarkan kategori
            if ($kategori) {
                $query->where('kategori', $kategori);
            }

            // Filter berdasarkan tanggal mulai dan selesai
            if ($startDate && $endDate) {
                $query->whereBetween('tanggal_mulai', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay()
                ]);
            } elseif ($startDate) {
                $query->whereDate('tanggal_mulai', '>=', Carbon::parse($startDate)->startOfDay());
            } elseif ($endDate) {
                $query->whereDate('tanggal_mulai', '<=', Carbon::parse($endDate)->endOfDay());
            }

            $agendas = $query->get();
        }

        // Paginate hasil query dengan filter yang diterapkan
        $today = now(); // Mendefinisikan variabel $today dengan tanggal dan waktu saat ini
        $agendas = Agenda::with('bidang', 'users', 'pegawai') // Memuat relasi 'bidang', 'users', dan 'pegawai'
            ->whereDate('tanggal_mulai', '>=', $today->subDay()) // Menyaring agenda yang tanggal mulainya adalah kemarin, hari ini, besok, dan seterusnya
            ->orderBy('tanggal_mulai', 'asc') // Mengurutkan berdasarkan tanggal mulai secara ascending
            ->orderBy('waktu_mulai', 'asc') // Mengurutkan berdasarkan waktu mulai secara ascending
            ->paginate(25); // Ambil semua agenda dengan relasi ke bidang
        // Ambil data bidang
        $bidangs = Bidang::all();
        $users = User::all();

        // Mengirimkan data agendaCount, agendas, dan bidangs ke view
        return view('dashboard', compact('agendaCount', 'agendas', 'bidangs', 'users'));
    }
}
