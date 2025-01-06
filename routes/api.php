<?php

use App\Models\Agenda;
use Illuminate\Support\Facades\Route;

Route::get('/agenda-count', function () {
    return response()->json([
        'umum' => Agenda::where('kategori', 'Umum')->count(),
        'penting' => Agenda::where('kategori', 'Penting')->count(),
        'rapat' => Agenda::where('kategori', 'Rapat')->count(),
    ]);
});
