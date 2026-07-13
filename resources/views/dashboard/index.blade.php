@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<div class="welcome-banner">
    <svg class="deco-svg" viewBox="0 0 300 200" xmlns="http://www.w3.org/2000/svg">
        <circle cx="260" cy="30" r="90" fill="#ffffff" opacity="0.06"/>
        <path d="M120,200 C160,150 200,190 260,150 C290,130 300,140 300,140 L300,200 Z" fill="#ffffff" opacity="0.08"/>
        <g opacity="0.5" stroke="#eaf3fd" stroke-width="2" fill="none">
            <circle cx="245" cy="70" r="26"/>
            <circle cx="270" cy="100" r="10"/>
        </g>
    </svg>
    <span class="role-badge"><i class="bi bi-{{ auth()->user()->isAdmin() ? 'shield-check' : 'person-check' }}"></i> {{ auth()->user()->isAdmin() ? 'Administrator' : 'Karyawan' }}</span>
    <h2>Halo, {{ auth()->user()->name }} 👋</h2>
    <p>
        @if(auth()->user()->isAdmin())
            Berikut ringkasan data karyawan &amp; departemen hari ini di EMS Portal.
        @else
            Selamat datang di EMS Portal. Anda dapat melihat Direktori Karyawan dan Departemen lewat menu di sidebar.
        @endif
    </p>
</div>

@if(auth()->user()->isAdmin())
<div class="row g-3">
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon icon-blue"><i class="bi bi-people"></i></div>
            <div class="stat-label">Total Karyawan</div>
            <div class="stat-value">{{ number_format($stats['total'], 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon icon-green"><i class="bi bi-person-check"></i></div>
            <div class="stat-label">Karyawan Aktif</div>
            <div class="stat-value">{{ number_format($stats['aktif'], 0, ',', '.') }}</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon icon-amber"><i class="bi bi-person-plus"></i></div>
            <div class="stat-label">Karyawan Baru Bulan Ini</div>
            <div class="stat-value">{{ $stats['baru_bulan_ini'] }}</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon icon-red"><i class="bi bi-calendar-x"></i></div>
            <div class="stat-label">Karyawan Cuti</div>
            <div class="stat-value">{{ $stats['cuti'] }}</div>
        </div>
    </div>
</div>

<div class="row g-3 mt-1">
    <div class="col-lg-7">
        <div class="card-panel p-3">
            <h6 class="fw-bold mb-3">Karyawan per Departemen</h6>
            @forelse($perDepartemen as $d)
                @php $pct = $stats['total'] > 0 ? round($d->karyawans_count / $stats['total'] * 100) : 0; @endphp
                <div class="mb-2">
                    <div class="d-flex justify-content-between small">
                        <span>{{ $d->nama_departemen }}</span>
                        <span class="text-muted">{{ $d->karyawans_count }} orang</span>
                    </div>
                    <div class="progress" style="height:6px;">
                        <div class="progress-bar" style="width:{{ $pct }}%;background:linear-gradient(90deg,#a9cdf0,#6ea8e0);"></div>
                    </div>
                </div>
            @empty
                <p class="text-muted small mb-0">Belum ada data departemen.</p>
            @endforelse
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card-panel p-3">
            <h6 class="fw-bold mb-3">Karyawan Terbaru</h6>
            <ul class="list-unstyled mb-0">
                @forelse($terbaru as $k)
                    <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <div>
                            <div class="fw-semibold small">{{ $k->nama }}</div>
                            <div class="text-muted" style="font-size:.78rem;">{{ $k->departemen->nama_departemen ?? '-' }}</div>
                        </div>
                        <span class="status-pill status-{{ $k->status }}">{{ $k->status }}</span>
                    </li>
                @empty
                    <p class="text-muted small mb-0">Belum ada data karyawan.</p>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<div class="mt-4 d-flex gap-2">
    <a href="{{ route('karyawan.index') }}" class="btn btn-brand"><i class="bi bi-people"></i> Kelola Karyawan</a>
    <a href="{{ route('departemen.index') }}" class="btn btn-outline-secondary"><i class="bi bi-building"></i> Kelola Departemen</a>
</div>

@else
<div class="row g-3">
    <div class="col-lg-7">
        <div class="card-panel p-4 h-100">
            <h6 class="fw-bold mb-3"><i class="bi bi-person-vcard me-1"></i> Informasi Akun</h6>
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="avatar" style="width:52px;height:52px;font-size:1.2rem;">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
                <div>
                    <div class="fw-semibold">{{ auth()->user()->name }}</div>
                    <div class="text-muted small">Karyawan</div>
                </div>
            </div>
            <p class="text-muted small mb-0">Akun Anda login sebagai <b>Karyawan</b>. Untuk mengubah nama atau kata sandi, buka menu <b>Pengaturan</b> di sidebar.</p>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card-panel p-4 h-100">
            <h6 class="fw-bold mb-3"><i class="bi bi-compass me-1"></i> Menu Cepat</h6>
            <div class="d-flex flex-column gap-2">
                <a href="{{ route('karyawan.payslip') }}" class="btn btn-brand text-white text-start"><i class="bi bi-cash-coin"></i> Lihat Slip Gaji</a>
                <a href="{{ route('karyawan.profile.edit') }}" class="btn btn-outline-secondary text-start"><i class="bi bi-person-lines-fill"></i> Edit Data Diri</a>
                <a href="{{ route('karyawan.index') }}" class="btn btn-outline-secondary text-start"><i class="bi bi-search"></i> Cari Rekan Kerja</a>
                <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary text-start"><i class="bi bi-gear"></i> Pengaturan Akun</a>
            </div>
            <p class="text-muted small mt-3 mb-0">Akses Anda bersifat lihat saja (read-only). Untuk menambah/mengubah/menghapus data, hubungi Admin.</p>
        </div>
    </div>
</div>
@endif

@endsection
