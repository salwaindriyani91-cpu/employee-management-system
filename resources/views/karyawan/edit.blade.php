@extends('layouts.app')
@section('title', 'Edit Karyawan')
@section('page-title', 'Edit Karyawan')

@section('content')
<div class="card-panel p-4" style="max-width:800px;">
    <form method="POST" action="{{ route('karyawan.update', $karyawan) }}">
        @csrf
        @method('PUT')
        @include('karyawan._form', ['karyawan' => $karyawan])
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-brand text-white">Perbarui</button>
            <a href="{{ route('karyawan.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
