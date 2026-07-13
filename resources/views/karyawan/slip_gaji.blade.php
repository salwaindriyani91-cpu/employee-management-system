@extends('layouts.app')
@section('title', 'Slip Gaji')
@section('page-title', 'Slip Gaji')

@section('content')

@if(!$karyawan)
    <div class="card-panel p-4">
        <p class="text-muted mb-0">Akun Anda belum tertaut ke data karyawan. Hubungi Admin untuk menautkan akun Anda agar Slip Gaji dapat ditampilkan.</p>
    </div>
@else
<div class="card-panel p-4" style="max-width:640px;">
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h5 class="fw-bold mb-1">Slip Gaji</h5>
            <div class="text-muted small">Periode {{ now()->translatedFormat('F Y') }}</div>
        </div>
        <span class="status-pill status-{{ $karyawan->status }}">{{ $karyawan->status }}</span>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6">
            <div class="text-muted small">Nama</div>
            <div class="fw-semibold">{{ $karyawan->nama }}</div>
        </div>
        <div class="col-6">
            <div class="text-muted small">NIP</div>
            <div class="fw-semibold">{{ $karyawan->nip }}</div>
        </div>
        <div class="col-6">
            <div class="text-muted small">Jabatan</div>
            <div class="fw-semibold">{{ $karyawan->jabatan }}</div>
        </div>
        <div class="col-6">
            <div class="text-muted small">Departemen</div>
            <div class="fw-semibold">{{ $karyawan->departemen->nama_departemen ?? '-' }}</div>
        </div>
        <div class="col-6">
            <div class="text-muted small">Tanggal Masuk</div>
            <div class="fw-semibold">{{ optional($karyawan->tanggal_masuk)->translatedFormat('d F Y') ?? '-' }}</div>
        </div>
    </div>

    <hr>

    <div class="d-flex justify-content-between align-items-center py-2">
        <span class="text-muted">Gaji Pokok</span>
        <span class="fw-bold fs-5">Rp {{ number_format($karyawan->gaji, 0, ',', '.') }}</span>
    </div>

    <p class="text-muted small mt-3 mb-0">
        <i class="bi bi-info-circle"></i>
        Slip ini bersifat read-only dan hanya menampilkan data milik Anda sendiri. Untuk pertanyaan terkait gaji, hubungi Admin/HR.
    </p>
</div>
@endif

@endsection
