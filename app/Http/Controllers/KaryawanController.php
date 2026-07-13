<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $query = Karyawan::with('departemen')
            ->search($request->input('q'))
            ->filter($request->only(['departemen_id', 'status', 'jenis_kelamin']));

        $sort = $request->input('sort', 'nama');
        $direction = $request->input('direction', 'asc');
        if (in_array($sort, ['nama', 'nip', 'tanggal_masuk', 'gaji'])) {
            $query->orderBy($sort, $direction === 'desc' ? 'desc' : 'asc');
        }

        $karyawans = $query->paginate(15)->withQueryString();
        $departemens = Departemen::orderBy('nama_departemen')->get();

        $stats = [
            'total' => Karyawan::count(),
            'aktif' => Karyawan::where('status', 'Aktif')->count(),
            'baru_bulan_ini' => Karyawan::whereMonth('tanggal_masuk', now()->month)
                ->whereYear('tanggal_masuk', now()->year)->count(),
            'cuti' => Karyawan::where('status', 'Cuti')->count(),
        ];

        return view('karyawan.index', compact('karyawans', 'departemens', 'stats'));
    }

    public function create()
    {
        $departemens = Departemen::orderBy('nama_departemen')->get();
        return view('karyawan.create', compact('departemens'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);
        Karyawan::create($validated);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function show(Karyawan $karyawan)
    {
        $karyawan->load('departemen');
        return view('karyawan.show', compact('karyawan'));
    }

    public function edit(Karyawan $karyawan)
    {
        $departemens = Departemen::orderBy('nama_departemen')->get();
        return view('karyawan.edit', compact('karyawan', 'departemens'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $validated = $this->validateData($request, $karyawan->id);
        $karyawan->update($validated);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        Karyawan::whereIn('id', $ids)->delete();
        return redirect()->route('karyawan.index')->with('success', count($ids) . ' data karyawan berhasil dihapus.');
    }

    private function validateData(Request $request, $ignoreId = null)
    {
        return $request->validate([
            'nip' => 'required|string|max:20|unique:karyawans,nip,' . $ignoreId,
            'nama' => 'required|string|max:100',
            'departemen_id' => 'required|exists:departemens,id',
            'jabatan' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:karyawans,email,' . $ignoreId,
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_masuk' => 'required|date',
            'gaji' => 'required|numeric|min:0',
            'status' => 'required|in:Aktif,Nonaktif,Cuti',
        ]);
    }

    // ---- IMPORT (format CSV, tanpa dependensi tambahan) ----
    public function importForm()
    {
        return view('karyawan.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:5120',
        ]);

        $handle = fopen($request->file('file')->getRealPath(), 'r');
        if (!$handle) {
            return back()->with('error', 'Gagal membaca file.');
        }

        $header = fgetcsv($handle);
        if (!$header) {
            fclose($handle);
            return back()->with('error', 'File kosong atau format tidak sesuai.');
        }
        $header = array_map(fn($h) => strtolower(trim($h)), $header);

        $imported = 0;
        $skipped = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, array_pad($row, count($header), null));

            if (empty($data['nip']) || empty($data['nama']) || empty($data['email'])) {
                $skipped++;
                continue;
            }
            if (Karyawan::where('nip', $data['nip'])->orWhere('email', $data['email'])->exists()) {
                $skipped++;
                continue;
            }

            $namaDept = trim($data['departemen'] ?? 'Umum');
            $departemen = Departemen::firstOrCreate(
                ['nama_departemen' => $namaDept],
                ['kode_departemen' => strtoupper(substr(preg_replace('/\s+/', '', $namaDept ?: 'UMUM'), 0, 6)) . rand(10, 99)]
            );

            Karyawan::create([
                'nip' => $data['nip'],
                'nama' => $data['nama'],
                'departemen_id' => $departemen->id,
                'jabatan' => $data['jabatan'] ?? '-',
                'email' => $data['email'],
                'no_telp' => $data['no_telp'] ?? null,
                'alamat' => $data['alamat'] ?? null,
                'tanggal_lahir' => !empty($data['tanggal_lahir']) ? date('Y-m-d', strtotime($data['tanggal_lahir'])) : null,
                'jenis_kelamin' => in_array(strtoupper($data['jenis_kelamin'] ?? 'L'), ['L', 'P']) ? strtoupper($data['jenis_kelamin']) : 'L',
                'tanggal_masuk' => !empty($data['tanggal_masuk']) ? date('Y-m-d', strtotime($data['tanggal_masuk'])) : now()->format('Y-m-d'),
                'gaji' => is_numeric($data['gaji'] ?? null) ? $data['gaji'] : 0,
                'status' => in_array($data['status'] ?? 'Aktif', ['Aktif', 'Nonaktif', 'Cuti']) ? $data['status'] : 'Aktif',
            ]);
            $imported++;
        }
        fclose($handle);

        if ($skipped > 0) {
            return redirect()->route('karyawan.index')
                ->with('warning', "{$imported} data berhasil diimpor. {$skipped} baris dilewati (data kosong/duplikat).");
        }

        return redirect()->route('karyawan.index')->with('success', "{$imported} data karyawan berhasil diimpor.");
    }

    public function downloadTemplate()
    {
        $columns = ['nip', 'nama', 'departemen', 'jabatan', 'email', 'no_telp', 'alamat', 'tanggal_lahir', 'jenis_kelamin', 'tanggal_masuk', 'gaji', 'status'];
        $sample = ['00123', 'Budi Santoso', 'Sumber Daya Manusia', 'Staff HR', 'budi.santoso@example.com', '081234567890', 'Jl. Melati No. 10, Jakarta', '1995-05-10', 'L', '2023-01-15', 6500000, 'Aktif'];

        return response()->streamDownload(function () use ($columns, $sample) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $columns);
            fputcsv($out, $sample);
            fclose($out);
        }, 'template_import_karyawan.csv', ['Content-Type' => 'text/csv']);
    }

    // ---- EXPORT (format CSV, terbuka langsung di Excel) ----
    public function exportExcel(Request $request)
    {
        return $this->exportCsv($request);
    }

    public function exportCsv(Request $request)
    {
        $filters = $request->only(['q', 'departemen_id', 'status', 'jenis_kelamin']);
        $data = Karyawan::with('departemen')
            ->search($filters['q'] ?? null)
            ->filter($filters)
            ->orderBy('nama')
            ->get();

        $filename = 'data_karyawan_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($data) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['NIP', 'Nama', 'Departemen', 'Jabatan', 'Email', 'No. Telp', 'Alamat', 'Tanggal Lahir', 'Jenis Kelamin', 'Tanggal Masuk', 'Gaji', 'Status']);
            foreach ($data as $k) {
                fputcsv($out, [
                    $k->nip, $k->nama, $k->departemen->nama_departemen ?? '-', $k->jabatan, $k->email,
                    $k->no_telp, $k->alamat,
                    optional($k->tanggal_lahir)->format('Y-m-d'),
                    $k->jenis_kelamin,
                    optional($k->tanggal_masuk)->format('Y-m-d'),
                    $k->gaji, $k->status,
                ]);
            }
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
