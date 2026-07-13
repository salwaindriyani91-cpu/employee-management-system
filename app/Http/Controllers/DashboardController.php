<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Karyawan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => Karyawan::count(),
            'aktif' => Karyawan::where('status', 'Aktif')->count(),
            'baru_bulan_ini' => Karyawan::whereMonth('tanggal_masuk', now()->month)
                ->whereYear('tanggal_masuk', now()->year)->count(),
            'cuti' => Karyawan::where('status', 'Cuti')->count(),
        ];

        $perDepartemen = Departemen::withCount('karyawans')->orderByDesc('karyawans_count')->limit(8)->get();

        $terbaru = Karyawan::with('departemen')->latest('tanggal_masuk')->limit(5)->get();

        return view('dashboard.index', compact('stats', 'perDepartemen', 'terbaru'));
    }
}
