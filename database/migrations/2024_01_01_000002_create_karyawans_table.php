<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 20)->unique();
            $table->string('nama', 100);
            $table->foreignId('departemen_id')->constrained('departemens')->cascadeOnDelete();
            $table->string('jabatan', 100);
            $table->string('email', 100)->unique();
            $table->string('no_telp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->default('L');
            $table->date('tanggal_masuk');
            $table->decimal('gaji', 15, 2)->default(0);
            $table->enum('status', ['Aktif', 'Nonaktif', 'Cuti'])->default('Aktif');
            $table->timestamps();

            $table->index(['nama', 'nip', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
