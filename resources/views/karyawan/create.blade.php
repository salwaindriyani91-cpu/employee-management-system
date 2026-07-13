@extends('layouts.app')
@section('title', 'Tambah Karyawan')
@section('page-title', 'Tambah Karyawan')

@section('content')
<div class="card-panel p-4" style="max-width:800px;">
    <form method="POST" action="{{ route('karyawan.store') }}">
        @csrf
        @include('karyawan._form', ['karyawan' => null])
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-brand text-white">Simpan</button>
            <a href="{{ route('karyawan.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
