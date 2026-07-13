@php $k = $karyawan; @endphp
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">NIP</label>
        <input type="text" name="nip" class="form-control" value="{{ old('nip', $k->nip ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="nama" class="form-control" value="{{ old('nama', $k->nama ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Departemen</label>
        <select name="departemen_id" class="form-select" required>
            <option value="">-- Pilih Departemen --</option>
            @foreach($departemens as $d)
                <option value="{{ $d->id }}" @selected(old('departemen_id', $k->departemen_id ?? '') == $d->id)>{{ $d->nama_departemen }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Jabatan</label>
        <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $k->jabatan ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $k->email ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">No. Telepon</label>
        <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp', $k->no_telp ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', optional($k->tanggal_lahir ?? null)->format('Y-m-d')) }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Jenis Kelamin</label>
        <select name="jenis_kelamin" class="form-select" required>
            <option value="L" @selected(old('jenis_kelamin', $k->jenis_kelamin ?? 'L') == 'L')>Laki-laki</option>
            <option value="P" @selected(old('jenis_kelamin', $k->jenis_kelamin ?? '') == 'P')>Perempuan</option>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Tanggal Masuk</label>
        <input type="date" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk', optional($k->tanggal_masuk ?? null)->format('Y-m-d')) }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Gaji (Rp)</label>
        <input type="number" step="0.01" name="gaji" class="form-control" value="{{ old('gaji', $k->gaji ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Status</label>
        <select name="status" class="form-select" required>
            @foreach(['Aktif','Nonaktif','Cuti'] as $s)
                <option value="{{ $s }}" @selected(old('status', $k->status ?? 'Aktif') == $s)>{{ $s }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12">
        <label class="form-label">Alamat</label>
        <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $k->alamat ?? '') }}</textarea>
    </div>
</div>
