<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KaryawanProfileController extends Controller
{
    /**
     * Tampilkan form "Data Diri" untuk karyawan.
     * Hanya field pribadi (no. telp, alamat, tanggal lahir, jenis kelamin)
     * yang bisa diubah. Field administratif (NIP, nama, departemen,
     * jabatan, gaji, status, tanggal masuk) tetap terkunci, hanya Admin
     * yang boleh mengubahnya lewat menu Karyawan.
     */
    public function edit(Request $request)
    {
        $karyawan = $request->user()->karyawan;

        return view('karyawan.profile_self', compact('karyawan'));
    }

    public function update(Request $request)
    {
        $karyawan = $request->user()->karyawan;

        if (! $karyawan) {
            return back()->with('error', 'Akun Anda belum tertaut ke data karyawan. Hubungi Admin untuk menautkan akun.');
        }

        $validated = $request->validate([
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        $karyawan->update($validated);

        return redirect()->route('karyawan.profile.edit')->with('success', 'Data diri berhasil diperbarui.');
    }

    /**
     * Tampilkan "Slip Gaji" ringkas untuk karyawan yang sedang login.
     * Hanya menampilkan data miliknya sendiri (read-only).
     */
    public function payslip(Request $request)
    {
        $karyawan = $request->user()->karyawan;

        return view('karyawan.slip_gaji', compact('karyawan'));
    }
}
