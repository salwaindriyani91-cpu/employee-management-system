@extends('layouts.app')
@section('title', 'Daftar Karyawan')
@section('page-title', 'Daftar Karyawan')

@section('content')
<div class="card-panel p-3 mb-3">
    <form method="GET" action="{{ route('karyawan.index') }}" class="row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label small text-muted mb-1">Cari</label>
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Nama, NIP, email, jabatan...">
        </div>
        <div class="col-md-2">
            <label class="form-label small text-muted mb-1">Departemen</label>
            <select name="departemen_id" class="form-select">
                <option value="">Semua</option>
                @foreach($departemens as $d)
                    <option value="{{ $d->id }}" @selected(request('departemen_id') == $d->id)>{{ $d->nama_departemen }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small text-muted mb-1">Status</label>
            <select name="status" class="form-select">
                <option value="">Semua</option>
                @foreach(['Aktif','Nonaktif','Cuti'] as $s)
                    <option value="{{ $s }}" @selected(request('status') == $s)>{{ $s }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small text-muted mb-1">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-select">
                <option value="">Semua</option>
                <option value="L" @selected(request('jenis_kelamin')=='L')>Laki-laki</option>
                <option value="P" @selected(request('jenis_kelamin')=='P')>Perempuan</option>
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-brand text-white flex-grow-1"><i class="bi bi-search"></i> Filter</button>
            <a href="{{ route('karyawan.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
        </div>
    </form>
</div>

<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <div class="text-muted small">Menampilkan {{ $karyawans->firstItem() ?? 0 }}–{{ $karyawans->lastItem() ?? 0 }} dari {{ $karyawans->total() }} karyawan</div>
    @if(auth()->user()->isAdmin())
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('karyawan.create') }}" class="btn btn-brand text-white"><i class="bi bi-plus-lg"></i> Tambah Karyawan</a>
        <a href="{{ route('karyawan.import.form') }}" class="btn btn-outline-primary"><i class="bi bi-upload"></i> Impor</a>
        <a href="{{ route('karyawan.export.csv', request()->query()) }}" class="btn btn-outline-secondary"><i class="bi bi-file-earmark-spreadsheet"></i> Ekspor</a>
    </div>
    @endif
</div>

<form method="POST" action="{{ route('karyawan.bulkDestroy') }}" id="bulk-form">
    @csrf
    @method('DELETE')
    <div class="card-panel p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        @if(auth()->user()->isAdmin())
                        <th style="width:30px;"><input type="checkbox" id="check-all"></th>
                        @endif
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Departemen</th>
                        <th>Jabatan</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($karyawans as $k)
                    <tr>
                        @if(auth()->user()->isAdmin())
                        <td><input type="checkbox" name="ids[]" value="{{ $k->id }}" class="row-check"></td>
                        @endif
                        @php $isSelf = auth()->user()->karyawan_id === $k->id; @endphp
                        <td>
                            @if(auth()->user()->isAdmin() || $isSelf)
                                {{ $k->nip }}
                            @else
                                <span class="text-muted" title="Tersembunyi demi keamanan akun">••••••</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('karyawan.show', $k) }}" class="text-decoration-none fw-semibold text-dark">{{ $k->nama }}</a>
                        </td>
                        <td>{{ $k->departemen->nama_departemen ?? '-' }}</td>
                        <td>{{ $k->jabatan }}</td>
                        <td>
                            @if(auth()->user()->isAdmin() || $isSelf)
                                {{ $k->email }}
                            @else
                                <span class="text-muted" title="Tersembunyi demi keamanan akun">••••••••</span>
                            @endif
                        </td>
                        <td><span class="status-pill status-{{ $k->status }}">{{ $k->status }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('karyawan.show', $k) }}" class="btn btn-sm btn-light" title="Detail"><i class="bi bi-eye"></i></a>
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('karyawan.edit', $k) }}" class="btn btn-sm btn-light" title="Edit"><i class="bi bi-pencil"></i></a>
                            <button type="button" class="btn btn-sm btn-light text-danger" title="Hapus"
                                onclick="if(confirm('Hapus data {{ $k->nama }}?')){document.getElementById('delete-{{ $k->id }}').submit();}">
                                <i class="bi bi-trash"></i>
                            </button>
                            <form id="delete-{{ $k->id }}" action="{{ route('karyawan.destroy', $k) }}" method="POST" class="d-none">
                                @csrf @method('DELETE')
                            </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="{{ auth()->user()->isAdmin() ? 8 : 7 }}" class="text-center text-muted py-4">Tidak ada data karyawan.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if(auth()->user()->isAdmin() && $karyawans->count() > 0)
        <div class="p-3 border-top">
            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus semua data terpilih?')">
                <i class="bi bi-trash"></i> Hapus Terpilih
            </button>
        </div>
        @endif
    </div>
</form>

<div class="mt-3">
    {{ $karyawans->links() }}
</div>

@push('scripts')
<script>
document.getElementById('check-all')?.addEventListener('change', function () {
    document.querySelectorAll('.row-check').forEach(cb => cb.checked = this.checked);
});
</script>
@endpush
@endsection
