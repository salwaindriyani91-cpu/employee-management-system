@extends('layouts.app')
@section('title', 'Tambah Departemen')
@section('page-title', 'Tambah Departemen')

@section('content')
<div class="card-panel p-4" style="max-width:600px;">
    <form method="POST" action="{{ route('departemen.store') }}">
        @csrf
        @include('departemen._form', ['departemen' => null])
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-brand text-white">Simpan</button>
            <a href="{{ route('departemen.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
