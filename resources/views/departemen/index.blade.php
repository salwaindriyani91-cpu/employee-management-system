@extends('layouts.app')
@section('title', 'Departemen')
@section('page-title', 'Departemen')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
    <form method="GET" class="d-flex gap-2">
        <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Cari departemen...">
        <button class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
    </form>
    @if(auth()->user()->isAdmin())
    <a href="{{ route('departemen.create') }}" class="btn btn-brand text-white"><i class="bi bi-plus-lg"></i> Tambah Departemen</a>
    @endif
</div>

<div class="card-panel p-0">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Departemen</th>
                    <th>Deskripsi</th>
                    <th>Jumlah Karyawan</th>
                    @if(auth()->user()->isAdmin())
                    <th class="text-end">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
            @forelse($departemens as $d)
                <tr>
                    <td>{{ $d->kode_departemen }}</td>
                    <td class="fw-semibold">{{ $d->nama_departemen }}</td>
                    <td class="text-muted">{{ $d->deskripsi ?? '-' }}</td>
                    <td>{{ $d->karyawans_count }}</td>
                    @if(auth()->user()->isAdmin())
                    <td class="text-end">
                        <a href="{{ route('departemen.edit', $d) }}" class="btn btn-sm btn-light"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('departemen.destroy', $d) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus departemen {{ $d->nama_departemen }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                    @endif
                </tr>
            @empty
                <tr><td colspan="{{ auth()->user()->isAdmin() ? 5 : 4 }}" class="text-center text-muted py-4">Belum ada departemen.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">{{ $departemens->links() }}</div>
@endsection
