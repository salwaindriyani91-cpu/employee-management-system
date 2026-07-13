@extends('layouts.app')
@section('title', 'Data Diri')
@section('page-title', 'Data Diri')

@section('content')

@if(!$karyawan)
<div class="card-panel p-4">
    <div class="d-flex align-items-start gap-3">
        <div class="stat-icon icon-amber"><i class="bi bi-exclamation-triangle"></i></div>
        <div>
            <h6 class="fw-bold mb-1">Akun belum tertaut ke data karyawan</h6>
            <p class="text-muted small mb-0">
                Akun Anda saat ini belum terhubung ke data karyawan manapun, sehingga menu ini belum bisa dipakai.
                Coba logout lalu login kembali menggunakan <b>NIP</b> atau <b>Email</b> yang terdaftar sebagai karyawan di sistem.
                Jika masih belum tertaut, hubungi Admin.
            </p>
        </div>
    </div>
</div>
@else
<div class="card-panel p-4" style="max-width:640px;">
    <h6 class="fw-bold mb-3"><i class="bi bi-person-vcard me-1"></i> Data Kepegawaian (dikunci Admin)</h6>
    <dl class="row mb-4">
        <dt class="col-4 text-muted">NIP</dt><dd class="col-8">{{ $karyawan->nip }}</dd>
        <dt class="col-4 text-muted">Nama</dt><dd class="col-8">{{ $karyawan->nama }}</dd>
        <dt class="col-4 text-muted">Departemen</dt><dd class="col-8">{{ $karyawan->departemen->nama_departemen ?? '-' }}</dd>
        <dt class="col-4 text-muted">Jabatan</dt><dd class="col-8">{{ $karyawan->jabatan }}</dd>
        <dt class="col-4 text-muted">Email Kantor</dt><dd class="col-8">{{ $karyawan->email }}</dd>
        <dt class="col-4 text-muted">Status</dt><dd class="col-8"><span class="status-pill status-{{ $karyawan->status }}">{{ $karyawan->status }}</span></dd>
    </dl>
    <p class="text-muted small mb-4">Data di atas hanya bisa diubah oleh Admin. Jika ada kesalahan, silakan hubungi HR/Admin.</p>

    <hr class="mb-4">

    <h6 class="fw-bold mb-3"><i class="bi bi-pencil-square me-1"></i> Edit Data Pribadi</h6>
    <form method="POST" action="{{ route('karyawan.profile.update') }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label small text-muted">No. Telepon</label>
            <input type="text" name="no_telp" value="{{ old('no_telp', $karyawan->no_telp) }}" class="form-control" placeholder="08xxxxxxxxxx">
        </div>

        <div class="mb-3">
            <label class="form-label small text-muted">Alamat</label>
            <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat domisili">{{ old('alamat', $karyawan->alamat) }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label small text-muted">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', optional($karyawan->tanggal_lahir)->format('Y-m-d')) }}" class="form-control">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label small text-muted">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-select">
                    <option value="L" @selected(old('jenis_kelamin', $karyawan->jenis_kelamin) == 'L')>Laki-laki</option>
                    <option value="P" @selected(old('jenis_kelamin', $karyawan->jenis_kelamin) == 'P')>Perempuan</option>
                </select>
            </div>
        </div>

        <button type="submit" class="btn btn-brand text-white"><i class="bi bi-check-lg"></i> Simpan Perubahan</button>
    </form>
</div>
@endif

@endsection
