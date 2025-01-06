<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\MeetingRoomController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::get('/dashboard/export/{format}', [DashboardController::class, 'export'])->name('dashboard.export');


Route::middleware('auth')->group(function () { // Untuk proses verifikasi
    // Routes for Data User
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::put('/users/{user}/promote', [UserController::class, 'promoteToAdmin'])->name('users.promote');
    Route::delete('/users/{user}', [UserController::class, 'delete'])->name('users.delete');

    // Routes for Agenda Kegiatan
    Route::get('/agendas', [AgendaController::class, 'index'])->name('agendas.index');

    // Menyimpan agenda baru
    Route::post('/agendaa', [AgendaController::class, 'store'])->name('agenda.store');

    // Menampilkan halaman edit agenda
    Route::get('/agendas/{id}/edit', [AgendaController::class, 'edit'])->name('agendas.edit');

    // Memperbarui agenda
    Route::put('/agendas/{id}', [AgendaController::class, 'update'])->name('agendas.update');

    // Menghapus agenda
    Route::delete('/agendas/{id}', [AgendaController::class, 'destroy'])->name('agendas.destroy');

    // Mengubah status laporan
    Route::post('/agenda/{id}/toggle-laporan', [AgendaController::class, 'toggleLaporan'])
        ->middleware('auth')
        ->name('agenda.toggleLaporan');

    Route::middleware(['auth'])->group(function () {
        Route::get('meeting-rooms', [MeetingRoomController::class, 'index'])->name('meeting-rooms.index');
        Route::get('meeting-rooms/create', [MeetingRoomController::class, 'create'])->name('meeting-rooms.create');
        Route::post('meeting-rooms', [MeetingRoomController::class, 'store'])->name('meeting-rooms.store');
        Route::get('meeting-rooms/{id}/edit', [MeetingRoomController::class, 'edit'])->name('meeting-rooms.edit');
        Route::put('meeting-rooms/{id}', [MeetingRoomController::class, 'update'])->name('meeting-rooms.update');
        Route::delete('meeting-rooms/{id}', [MeetingRoomController::class, 'destroy'])->name('meeting-rooms.destroy');

        // Route untuk toggle status laporan
        Route::post('meeting-rooms/{id}/toggle-laporan', [MeetingRoomController::class, 'toggleLaporan'])->name('meetingrooms.toggleLaporan');
    });


    // Rute untuk halaman verifikasi
    // Route untuk menampilkan form validasi NIP
    Route::get('/pegawai/validate-nip', [VerificationController::class, 'showValidationForm'])->name('pegawai.validate-nip');

    // Route untuk memvalidasi NIP
    Route::post('/pegawai/validate-nip', [VerificationController::class, 'validateNip'])->name('pegawai.validate-nip.process');

    // Route untuk menampilkan form pembuatan pegawai (untuk role admin dan staff)
    Route::get('/pegawai/create', [VerificationController::class, 'showCreateForm'])->name('pegawai.create');

    // Route untuk menyimpan data pegawai baru
    Route::post('/pegawai/create', [VerificationController::class, 'createPegawai'])->name('pegawai.store');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
