<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role_id')) {
                $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            }
            if (!Schema::hasColumn('users', 'bidang_id')) {
                $table->foreignId('bidang_id')->nullable()->constrained('bidang')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role_id')) {
                $foreignKeys = DB::select('SHOW KEYS FROM users WHERE Key_name = "users_role_id_foreign"');
                if (!empty($foreignKeys)) {
                    $table->dropForeign(['role_id']);
                }
                $table->dropColumn('role_id');
            }
            if (Schema::hasColumn('users', 'bidang_id')) {
                $foreignKeys = DB::select('SHOW KEYS FROM users WHERE Key_name = "users_bidang_id_foreign"');
                if (!empty($foreignKeys)) {
                    $table->dropForeign(['bidang_id']);
                }
                $table->dropColumn('bidang_id');
            }
        });
    }
};
