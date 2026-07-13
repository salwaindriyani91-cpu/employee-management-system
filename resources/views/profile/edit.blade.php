@extends('layouts.app')
@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Akun')

@section('content')
<div class="row g-3">
    <div class="col-lg-6">
        <div class="card-panel p-4">
            <h6 class="fw-bold mb-3">Profil</h6>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email / Username</label>
                    <input type="text" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>
                <button type="submit" class="btn btn-brand">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card-panel p-4">
            <h6 class="fw-bold mb-3">Ubah Password</h6>
            <form method="POST" action="{{ route('profile.password') }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Password Saat Ini</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-brand">Ubah Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
