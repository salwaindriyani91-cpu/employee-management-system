<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nip',
        'nama',
        'departemen_id',
        'jabatan',
        'email',
        'no_telp',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'tanggal_masuk',
        'gaji',
        'status',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'date',
        'gaji' => 'decimal:2',
    ];

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }

    public function scopeSearch($query, $keyword)
    {
        if (!$keyword) return $query;

        return $query->where(function ($q) use ($keyword) {
            $q->where('nama', 'like', "%{$keyword}%")
              ->orWhere('nip', 'like', "%{$keyword}%")
              ->orWhere('email', 'like', "%{$keyword}%")
              ->orWhere('jabatan', 'like', "%{$keyword}%");
        });
    }

    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['departemen_id'] ?? null, fn($q, $v) => $q->where('departemen_id', $v))
            ->when($filters['status'] ?? null, fn($q, $v) => $q->where('status', $v))
            ->when($filters['jenis_kelamin'] ?? null, fn($q, $v) => $q->where('jenis_kelamin', $v));
    }
}
