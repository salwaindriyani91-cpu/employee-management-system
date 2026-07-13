@extends('layouts.app')
@section('title', 'Edit Departemen')
@section('page-title', 'Edit Departemen')

@section('content')
<div class="card-panel p-4" style="max-width:600px;">
    <form method="POST" action="{{ route('departemen.update', $departemen) }}">
        @csrf
        @method('PUT')
        @include('departemen._form', ['departemen' => $departemen])
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-brand text-white">Perbarui</button>
            <a href="{{ route('departemen.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
