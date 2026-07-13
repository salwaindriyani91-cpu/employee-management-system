@extends('layouts.app')
@section('title', 'Impor / Ekspor Data')
@section('page-title', 'Impor / Ekspor Data Karyawan')

@section('content')
<div class="row g-3">
    <div class="col-lg-6">
        <div class="card-panel p-4 h-100">
            <h6 class="fw-bold mb-2"><i class="bi bi-upload"></i> Impor Data</h6>
            <p class="text-muted small">Unggah file CSV dengan kolom: <code>nip, nama, departemen, jabatan, email, no_telp, alamat, tanggal_lahir, jenis_kelamin, tanggal_masuk, gaji, status</code>. File CSV bisa dibuka dan disimpan langsung dari Excel.</p>

            <a href="{{ route('karyawan.import.template') }}" class="btn btn-sm btn-outline-secondary mb-3">
                <i class="bi bi-download"></i> Unduh Template CSV
            </a>

            <form method="POST" action="{{ route('karyawan.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Pilih File CSV</label>
                    <input type="file" name="file" class="form-control" accept=".csv,.txt" required>
                </div>
                <button type="submit" class="btn btn-brand"><i class="bi bi-upload"></i> Impor Sekarang</button>
            </form>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card-panel p-4 h-100">
            <h6 class="fw-bold mb-2"><i class="bi bi-download"></i> Ekspor Data</h6>
            <p class="text-muted small">Unduh seluruh data karyawan yang tersimpan saat ini dalam format CSV (langsung terbuka di Excel).</p>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('karyawan.export.csv') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-file-earmark-spreadsheet"></i> Ekspor Data (CSV)
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
