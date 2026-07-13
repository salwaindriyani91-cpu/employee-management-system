@php $d = $departemen; @endphp
<div class="mb-3">
    <label class="form-label">Kode Departemen</label>
    <input type="text" name="kode_departemen" class="form-control" value="{{ old('kode_departemen', $d->kode_departemen ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Nama Departemen</label>
    <input type="text" name="nama_departemen" class="form-control" value="{{ old('nama_departemen', $d->nama_departemen ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $d->deskripsi ?? '') }}</textarea>
</div>
