@extends('layouts.app')
@section('title', 'Laporan')
@section('page-title', 'Laporan Karyawan')

@section('content')
<div class="d-flex justify-content-end mb-3 no-print">
    <button onclick="window.print()" class="btn btn-outline-secondary btn-sm"><i class="bi bi-printer"></i> Cetak</button>
</div>

<div class="row g-3 mb-1">
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-label">Total Karyawan</div>
            <div class="stat-value">{{ number_format($total, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-label">Karyawan Aktif</div>
            <div class="stat-value">{{ number_format($perStatus['Aktif'] ?? 0, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-label">Total Gaji Aktif / Bulan</div>
            <div class="stat-value" style="font-size:1.1rem;">Rp {{ number_format($totalGaji, 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-label">Jumlah Departemen</div>
            <div class="stat-value">{{ $perDepartemen->count() }}</div>
        </div>
    </div>
</div>

<div class="row g-3 mt-1">
    <div class="col-lg-7">
        <div class="card-panel p-3">
            <h6 class="fw-bold mb-3">Karyawan per Departemen</h6>
            <table class="table table-sm mb-0">
                <thead><tr><th>Departemen</th><th class="text-end">Jumlah Karyawan</th></tr></thead>
                <tbody>
                    @forelse($perDepartemen as $d)
                        <tr>
                            <td>{{ $d->nama_departemen }}</td>
                            <td class="text-end">{{ $d->karyawans_count }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="text-muted text-center">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card-panel p-3 mb-3">
            <h6 class="fw-bold mb-3">Status Karyawan</h6>
            <table class="table table-sm mb-0">
                <tbody>
                    @foreach(['Aktif', 'Nonaktif', 'Cuti'] as $status)
                        <tr>
                            <td><span class="status-pill status-{{ $status }}">{{ $status }}</span></td>
                            <td class="text-end">{{ $perStatus[$status] ?? 0 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-panel p-3">
            <h6 class="fw-bold mb-3">Jenis Kelamin</h6>
            <table class="table table-sm mb-0">
                <tbody>
                    <tr><td>Laki-laki</td><td class="text-end">{{ $perGender['L'] ?? 0 }}</td></tr>
                    <tr><td>Perempuan</td><td class="text-end">{{ $perGender['P'] ?? 0 }}</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @media print {
        .sidebar, .topbar, .no-print { display: none !important; }
        .content { padding: 0 !important; }
    }
</style>
@endsection
