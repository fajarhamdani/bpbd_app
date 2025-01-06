<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKategoriToAgendaTable extends Migration
{
    public function up()
    {
        Schema::table('agenda', function (Blueprint $table) {
            $table->string('kategori')->after('nama_acara'); // Menambahkan kolom kategori
        });
    }

    public function down()
    {
        Schema::table('agenda', function (Blueprint $table) {
            $table->dropColumn('kategori'); // Menghapus kolom kategori jika migrasi dibatalkan
        });
    }
}
