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

        // Mulai query agenda
        $query = Agenda::query();

        // Filter berdasarkan nama acara
        if ($search) {
            $query->whereRaw('LOWER(nama_acara) LIKE ?', ['%' . strtolower($search) . '%']);
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

        // Paginate hasil query dengan filter yang diterapkan
        $today = now(); // Mendefinisikan variabel $today dengan tanggal dan waktu saat ini
        $yesterday = $today->copy()->subDay(); // Mendefinisikan variabel $yesterday dengan tanggal kemarin
        $tomorrow = $today->copy()->addDay(); // Mendefinisikan variabel $tomorrow dengan tanggal besok

        $agendas = $query->with('bidang', 'users', 'pegawai') // Memuat relasi 'bidang', 'users', dan 'pegawai'
            ->orderByRaw("CASE 
            WHEN DATE(tanggal_mulai) = ? THEN 0 
            WHEN DATE(tanggal_mulai) = ? THEN 1 
            WHEN DATE(tanggal_mulai) = ? THEN 2 
            ELSE 3 END", [$tomorrow->toDateString(), $today->toDateString(), $yesterday->toDateString()]) // Menempatkan agenda besok di paling atas, diikuti hari ini, lalu kemarin
            ->orderBy('tanggal_mulai', 'desc') // Mengurutkan berdasarkan tanggal mulai secara descending
            ->orderBy('waktu_mulai', 'asc') // Mengurutkan berdasarkan waktu mulai secara ascending
            ->paginate(25);

        // Ambil data bidang
        $bidangs = Bidang::all();
        $users = User::all();

        // Mengirimkan data agendaCount, agendas, dan bidangs ke view
        return view('dashboard', compact('agendaCount', 'agendas', 'bidangs', 'users'));
    }
}
