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
            $query->where('nama_acara', 'like', '%' . $search . '%');
        }

        // Filter berdasarkan kategori
        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        // Filter berdasarkan tanggal mulai dan selesai
        // if ($startDate && $endDate) {
        //     $query->whereBetween('tanggal_mulai', [
        //         Carbon::parse($startDate)->startOfDay(),
        //         Carbon::parse($endDate)->endOfDay()
        //     ]);
        // }

        // Paginate hasil query dengan filter yang diterapkan
        $agendas = $query->paginate(30);

        // Ambil data bidang
        $bidangs = Bidang::all();
        $users = User::all();

        // Mengirimkan data agendaCount, agendas, dan bidangs ke view
        return view('dashboard', compact('agendaCount', 'agendas', 'bidangs', 'users'));
    }

    
}
