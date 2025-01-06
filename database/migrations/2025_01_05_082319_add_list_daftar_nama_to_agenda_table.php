<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agenda', function (Blueprint $table) {
            if (!Schema::hasColumn('agenda', 'list_daftar_nama')) {
                $table->json('list_daftar_nama')->nullable()->after('tempat');
            }
        });
    }

    public function down(): void
    {
        Schema::table('agenda', function (Blueprint $table) {
            if (Schema::hasColumn('agenda', 'list_daftar_nama')) {
                $table->dropColumn('list_daftar_nama');
            }
        });
    }
};
