<?php

namespace Database\Seeders;

use App\Models\Departemen;
use Illuminate\Database\Seeder;

class DepartemenSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode_departemen' => 'HR', 'nama_departemen' => 'Sumber Daya Manusia', 'deskripsi' => 'Mengelola rekrutmen, pelatihan, dan kesejahteraan karyawan.'],
            ['kode_departemen' => 'FIN', 'nama_departemen' => 'Keuangan', 'deskripsi' => 'Mengelola anggaran, pembukuan, dan laporan keuangan perusahaan.'],
            ['kode_departemen' => 'IT', 'nama_departemen' => 'Teknologi Informasi', 'deskripsi' => 'Mengelola infrastruktur IT, pengembangan sistem, dan keamanan data.'],
            ['kode_departemen' => 'MKT', 'nama_departemen' => 'Pemasaran', 'deskripsi' => 'Mengelola strategi pemasaran, branding, dan promosi produk.'],
            ['kode_departemen' => 'OPS', 'nama_departemen' => 'Operasional', 'deskripsi' => 'Mengelola kegiatan operasional harian perusahaan.'],
            ['kode_departemen' => 'SLS', 'nama_departemen' => 'Penjualan', 'deskripsi' => 'Mengelola penjualan produk dan hubungan pelanggan.'],
            ['kode_departemen' => 'LGL', 'nama_departemen' => 'Legal', 'deskripsi' => 'Menangani aspek hukum dan kepatuhan perusahaan.'],
            ['kode_departemen' => 'PRD', 'nama_departemen' => 'Produksi', 'deskripsi' => 'Mengelola proses produksi dan kontrol kualitas.'],
        ];

        foreach ($data as $row) {
            Departemen::firstOrCreate(['kode_departemen' => $row['kode_departemen']], $row);
        }
    }
}
