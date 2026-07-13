@extends('layouts.app')
@section('title', 'Detail Karyawan')
@section('page-title', 'Detail Karyawan')

@section('content')
<div class="card-panel p-4" style="max-width:700px;">
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div class="d-flex align-items-center gap-3">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($karyawan->nama) }}&background=2563eb&color=fff&size=64" class="rounded-circle" width="64" height="64">
            <div>
                <h4 class="mb-0 fw-bold">{{ $karyawan->nama }}</h4>
                <div class="text-muted">{{ $karyawan->jabatan }} &middot; {{ $karyawan->departemen->nama_departemen ?? '-' }}</div>
            </div>
        </div>
        <span class="status-pill status-{{ $karyawan->status }}">{{ $karyawan->status }}</span>
    </div>

    @php $isSelf = auth()->user()->karyawan_id === $karyawan->id; @endphp
    <dl class="row mb-0">
        <dt class="col-4 text-muted">NIP</dt>
        <dd class="col-8">
            @if(auth()->user()->isAdmin() || $isSelf)
                {{ $karyawan->nip }}
            @else
                <span class="text-muted" title="Tersembunyi demi keamanan akun">••••••</span>
            @endif
        </dd>
        <dt class="col-4 text-muted">Email</dt>
        <dd class="col-8">
            @if(auth()->user()->isAdmin() || $isSelf)
                {{ $karyawan->email }}
            @else
                <span class="text-muted" title="Tersembunyi demi keamanan akun">••••••••</span>
            @endif
        </dd>
        <dt class="col-4 text-muted">No. Telepon</dt><dd class="col-8">{{ $karyawan->no_telp ?? '-' }}</dd>
        <dt class="col-4 text-muted">Jenis Kelamin</dt><dd class="col-8">{{ $karyawan->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
        <dt class="col-4 text-muted">Tanggal Lahir</dt><dd class="col-8">{{ optional($karyawan->tanggal_lahir)->format('d M Y') ?? '-' }}</dd>
        <dt class="col-4 text-muted">Tanggal Masuk</dt><dd class="col-8">{{ optional($karyawan->tanggal_masuk)->format('d M Y') }}</dd>
        <dt class="col-4 text-muted">Gaji</dt><dd class="col-8">Rp {{ number_format($karyawan->gaji, 0, ',', '.') }}</dd>
        <dt class="col-4 text-muted">Alamat</dt><dd class="col-8">{{ $karyawan->alamat ?? '-' }}</dd>
    </dl>

    <div class="mt-4 d-flex gap-2">
        @if(auth()->user()->isAdmin())
        <a href="{{ route('karyawan.edit', $karyawan) }}" class="btn btn-brand text-white"><i class="bi bi-pencil"></i> Edit</a>
        @endif
        <a href="{{ route('karyawan.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>
</div>
@endsection
