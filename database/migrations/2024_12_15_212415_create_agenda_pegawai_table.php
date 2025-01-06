<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('agenda_pegawai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agenda_id')->constrained('agenda')->onDelete('cascade');
            $table->foreignId('pegawai_id')->constrained('pegawai')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agenda_pegawai');
    }
};
