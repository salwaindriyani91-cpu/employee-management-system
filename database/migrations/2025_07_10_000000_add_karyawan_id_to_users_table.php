<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menautkan akun login (users) ke data karyawan (karyawans),
     * supaya karyawan bisa mengedit data dirinya sendiri (no. telp, alamat, dll).
     * Satu akun hanya boleh tertaut ke satu data karyawan (unique).
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('karyawan_id')->nullable()->unique()
                ->after('role')
                ->constrained('karyawans')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('karyawan_id');
        });
    }
};
