<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Karyawan;

class ReportController extends Controller
{
    /**
     * Halaman laporan ringkasan karyawan.
     */
    public function index()
    {
        $total = Karyawan::count();

        $perDepartemen = Departemen::withCount('karyawans')
            ->orderByDesc('karyawans_count')
            ->get();

        $perStatus = Karyawan::selectRaw('status, count(*) as jumlah')
            ->groupBy('status')
            ->pluck('jumlah', 'status');

        $perGender = Karyawan::selectRaw('jenis_kelamin, count(*) as jumlah')
            ->groupBy('jenis_kelamin')
            ->pluck('jumlah', 'jenis_kelamin');

        $totalGaji = Karyawan::where('status', 'Aktif')->sum('gaji');

        return view('laporan.index', compact('total', 'perDepartemen', 'perStatus', 'perGender', 'totalGaji'));
    }
}
